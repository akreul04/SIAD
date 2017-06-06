import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.SocketException;
import java.util.Date;
import java.util.HashMap;


public class MyTCPMultiThreadServer{

	static HashMap<TCPServerThread, String> clients = new HashMap<TCPServerThread, String>();
	
	public static void main(String[] args) throws IOException {
		System.out.println("MyTCPServer");
		int portNumber = 8000;
		String username;
		ServerSocket serverSocket  = new ServerSocket(portNumber); //this line is equivalent to socket, bind and listen in C
		System.out.println("MyTCPServer is running on port " + serverSocket.getLocalPort());

		while(true){ //keep server running continously
			Socket clientSocket = serverSocket.accept(); //start accepting client connections, blocking until a client connects
			BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream())); //create reader to read from client socket for username
			username = in.readLine(); //recieve user name from client
			System.out.println(username + " has connected");
			
			
			TCPServerThread tcpThread = new TCPServerThread(clientSocket);
			tcpThread.setUserName(username);
			clients.put(tcpThread, username); //store hashmap of client threads and usernames

			tcpThread.start();
			
				for(TCPServerThread key: clients.keySet()){
					PrintWriter out = new PrintWriter(key.getSocket().getOutputStream(), true);
					out.println(username + " has connected");
	
				}
			
			

			
			} 
			

	}
	
	public static String getUsers(){
		String users = "";
		for(TCPServerThread key : clients.keySet()){
			users = users + " " + key.getUserName();
		}
		return "Current Users: " + users;
	}
	
	public static void sendMessage(String input, TCPServerThread sender) throws IOException {
		for(TCPServerThread key: clients.keySet()){
			if(!clients.get(key).equals(sender.getUserName())){
				PrintWriter out = new PrintWriter(key.getSocket().getOutputStream(), true);
				out.println(sender.getUserName() + " says: " + input);
			}
		}
	}
	
	public static void Exit(TCPServerThread sender) throws IOException {
		for(TCPServerThread key: clients.keySet()){
			
			if(clients.get(key).equals(sender.getUserName())){
				clients.remove(key);
				break;
			}
				
		}
		
		for(TCPServerThread key: clients.keySet()){
			PrintWriter out = new PrintWriter(key.getSocket().getOutputStream(), true);
			out.println(sender.getUserName() + " has left the chat");
		}
	}
}


class TCPServerThread extends Thread {

	private Socket clientSocket = null;
	private String username = "";

	TCPServerThread(Socket clientSocket){
		super("TCPServerThread");
		this.clientSocket = clientSocket;
	}

	public void run(){
		try{
		BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
		PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
		String inputLine = in.readLine();
		String receivedData = inputLine;


		while(true){ //while still receiving data, add to receivedData string
			System.out.println(inputLine);
			
			if(inputLine.equals("*Get Users")){
				out.println(MyTCPMultiThreadServer.getUsers());
				inputLine = in.readLine();
			}else if(inputLine.equals("*Exit")){
				MyTCPMultiThreadServer.Exit(this);
				break;
			}else{
				MyTCPMultiThreadServer.sendMessage(inputLine, this);
				inputLine = in.readLine();
				
			}
			
		}
		}catch(SocketException e){
			try{
				MyTCPMultiThreadServer.Exit(this);
				System.out.println("test");
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
}
