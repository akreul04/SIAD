import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.Date;
import java.util.ArrayList;


public class MyTCPMultiThreadServer{
	public static void main(String[] args) throws IOException {
		System.out.println("MyTCPServer");
		int portNumber = 8000;
		ArrayList<String> userNames = new ArrayList<String>();
		ServerSocket serverSocket  = new ServerSocket(portNumber); //this line is equivalent to socket, bind and listen in C
		System.out.println("MyTCPServer is running on port " + serverSocket.getLocalPort());

		while(true){
			Socket clientSocket = serverSocket.accept(); //start accepting client connections, blocking until a client connects
			TCPServerThread tcpThread = new TCPServerThread(clientSocket);
			tcpThread.start();
			//BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));

			//if(in.readLine().equals("Get User List")){
			//	System.out.println(tcpThread.getUserName());
			//}
			} 
			

	}
}


class TCPServerThread extends Thread {

	private Socket clientSocket = null;
	private String userName;

	TCPServerThread(Socket clientSocket){
		super("TCPServerThread");
		this.clientSocket = clientSocket;
	}

	public void run(){
		try{
		BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
		//PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
		String inputLine = in.readLine();
		String receivedData = inputLine;
		userName = inputLine;

		System.out.println(userName);

		while(!inputLine.isEmpty()){ //while still receiving data, add to receivedData string
			inputLine = in.readLine();
			if(inputLine.equals("Users")){
				System.out.println(this.getUserName());
			}
			System.out.println(inputLine);
			receivedData += inputLine + "\n";

			
		}

		System.out.println("Data received from client:" + receivedData);

		String response = "MyTCPServer\n" + (new Date()).toString() + "\n" + "You have sent: " + receivedData;
		clientSocket.getOutputStream().write(response.getBytes("UTF-8"));
		}catch(IOException e){
			System.out.println(e.getMessage());
		}
	}

	public String getUserName(){
		return userName;
	}
}
