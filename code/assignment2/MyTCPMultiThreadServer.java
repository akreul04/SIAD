import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.SocketException;
import java.util.Date;
import java.util.HashMap;


public class MyTCPMultiThreadServer implements Runnable{

	static HashMap<TCPServerThread, String> clients = new HashMap<TCPServerThread, String>();
	String username;
	static ServerSocket serverSocket; //this line is equivalent to socket, bind and listen in C

	public static void main(String[] args){
		try{
			int portNumber = 8000;
			serverSocket  = new ServerSocket(portNumber); //this line is equivalent to socket, bind and listen in C
			System.out.println("MyTCPServer");
			System.out.println("MyTCPServer is running on port " + serverSocket.getLocalPort());
			Thread thread = new Thread(new MyTCPMultiThreadServer());
			thread.start();
		}catch(IOException e){
			System.out.println(e.getMessage());
		}
		
			

	}
	
	public void run(){
		try{
			while(true){ //keep server running continously
				Socket clientSocket = serverSocket.accept(); //start accepting client connections, blocking until a client connects
				BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream())); //create reader to read from client socket for username
				username = in.readLine(); //recieve user name from client
				System.out.println(username + " has connected");
			
			
				TCPServerThread tcpThread = new TCPServerThread(this, clientSocket);
				tcpThread.setUserName(username);
				clients.put(tcpThread, username); //store hashmap of client threads and usernames

				tcpThread.start();
			
					for(TCPServerThread key: clients.keySet()){
						PrintWriter out = new PrintWriter(key.getSocket().getOutputStream(), true);
						out.println(username + " has connected");
					}
				}
		}catch(IOException e){
			System.out.println(e.getMessage());
		}
		
	}

	
	
	public synchronized String getUsers(){
		String users = "";
		synchronized(clients){
			for(TCPServerThread key : clients.keySet()){
				users = users + " " + key.getUserName();
			}
		}
		return "Current Users: " + users;
	}
	
	public synchronized void sendMessage(String input, TCPServerThread sender) throws IOException {
		for(TCPServerThread key: clients.keySet()){
			if(!clients.get(key).equals(sender.getUserName())){
				//PrintWriter out = new PrintWriter(key.getSocket().getOutputStream(), true);
				key.send(sender.getUserName() + " says: " + input);
			}
		}
	}
	
	public synchronized void Exit(TCPServerThread sender) throws IOException {
		synchronized(clients){
			for(TCPServerThread key: clients.keySet()){
			
				if(clients.get(key).equals(sender.getUserName())){
					clients.remove(key);
					break;
				}
				
			}
		
			for(TCPServerThread key: clients.keySet()){
				//PrintWriter out = new PrintWriter(key.getSocket().getOutputStream(), true);
				key.send(sender.getUserName() + " has left the chat");
			}
		}
	}
}


class TCPServerThread extends Thread {

	private Socket clientSocket = null;
	private String username = "";
	private MyTCPMultiThreadServer server;
	private PrintWriter out;

	TCPServerThread(MyTCPMultiThreadServer server, Socket clientSocket) throws IOException{
		super("TCPServerThread");
		this.clientSocket = clientSocket;
		this.server = server;
		this.out = new PrintWriter(clientSocket.getOutputStream(), true);
	}

	public void run(){
		try{
			BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
			//PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
			String inputLine = in.readLine();
			String receivedData = inputLine;


			while(true){ //while still receiving data, add to receivedData string
				System.out.println(inputLine);
			
				if(inputLine.equals("*Get Users")){
					out.println(server.getUsers());
					inputLine = in.readLine();
				}else if(inputLine.equals("*Exit")){
					server.Exit(this);
					break;
				}else{
					server.sendMessage(inputLine, this);
					inputLine = in.readLine();
				
				}
			
			}
			
		}catch(SocketException e){
			try{
				server.Exit(this);
			}catch (IOException e2){
				System.out.println(e2.getMessage());
			}
		
		}catch(IOException e3){
			System.out.println(e3.getMessage());
		}
		
		
	}

	public Socket getSocket(){
		return this.clientSocket;
	}
	
	public void setUserName(String username){
		this.username = username;
	}
	
	public String getUserName(){
		return username;
	}
	
	public void send(String input){ //create send method so I don't have to create output stream with each send
		out.println(input);
	}
}
