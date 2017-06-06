import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.Date;
import java.util.HashMap;


public class MyTCPMultiThreadServer{
	//static String users = "";
	static HashMap<TCPServerThread, String> clients = new HashMap<TCPServerThread, String>();
	//static String username="";
	public static void main(String[] args) throws IOException {
		System.out.println("MyTCPServer");
		int portNumber = 8000;
		String username;
		//HashMap<TCPServerThread, String> clients = new HashMap<TCPServerThread, String>();
		ServerSocket serverSocket  = new ServerSocket(portNumber); //this line is equivalent to socket, bind and listen in C
		System.out.println("MyTCPServer is running on port " + serverSocket.getLocalPort());

		while(true){ //keep server running continously
			Socket clientSocket = serverSocket.accept(); //start accepting client connections, blocking until a client connects
			BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream())); //create reader to read from client socket for username
			//PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
			username = in.readLine(); //recieve user name from client
			System.out.println(username + " has connected");
			//users = users + " " + username;
			//System.out.println(getUsers());
			
			TCPServerThread tcpThread = new TCPServerThread(clientSocket);
			tcpThread.setUserName(username);
			clients.put(tcpThread, username); //store hashmap of client threads and usernames

			tcpThread.start();
			for(TCPServerThread key: clients.keySet()){
				PrintWriter out = new PrintWriter(key.getSocket().getOutputStream(), true);
				out.println(username + " has connected");
	
			}
			
			

			//if(in.readLine().equals("Get User List")){
			//	System.out.println(tcpThread.getUserName());
			//}
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
			if(clients.get(key).equals(sender.getUserName()))
				clients.remove(key);
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
		//userName = inputLine;

		//System.out.println(userName);

		while(true){ //while still receiving data, add to receivedData string
			System.out.println(inputLine);
			
			if(inputLine.equals("*Get Users")){
				out.println(MyTCPMultiThreadServer.getUsers());
				inputLine = in.readLine();
				//receivedData += inputLine + "\n";
			}else if(inputLine.equals("*Exit")){
				MyTCPMultiThreadServer.Exit(this);
				this.clientSocket.close();
				inputLine = in.readLine();
			}else{
				MyTCPMultiThreadServer.sendMessage(inputLine, this);
			//if(inputLine.equals("Exit")
				
			
				inputLine = in.readLine();
			//if(inputLine.equals("Users")){
			//	System.out.println(this.getUserName());
		//	}
			//System.out.println(inputLine);
				receivedData += inputLine + "\n";
			}
			
		}

		//System.out.println("Data received from client:" + receivedData);

		//String response = "MyTCPServer\n" + (new Date()).toString() + "\n" + "You have sent: " + receivedData;
		//clientSocket.getOutputStream().write(response.getBytes("UTF-8"));
		}catch(IOException e){
			System.out.println(e.getMessage());
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
