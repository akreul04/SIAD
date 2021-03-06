import java.io.*;
import java.net.*;

public class MyTCPClient{
	

	public static void main(String[] args) throws IOException{
		String userName;
		String userInput;

		if(args.length != 2){
			System.err.println("Usage: java MyTCPClient <host name><port number>");
			System.exit(1);
		}

		String hostname = args[0];
		int portNumber = Integer.parseInt(args[1]);

		try{
		Socket socket  = new Socket(hostname, portNumber);
		
		//output stream to send data
		PrintWriter out = new PrintWriter(socket.getOutputStream(), true);
		//buffered reader to read from user input
		BufferedReader stdIn = new BufferedReader(new InputStreamReader(System.in));
		
		System.out.println("Please enter a user name: ");
		userName = stdIn.readLine();
		out.println(userName); //send username to server
		System.out.print("Welcome to the chat!  Menu Options: \n *GetUsers for list of users \n *Exit to exit\n\n");
		new TCPClientThread(socket).start();
		while ((userInput = stdIn.readLine()) != null){
			out.println(userInput);
			
				if(userInput.equals("*Exit")){
					socket.close();
					System.exit(1);
				}
			
		}

		}catch(UnknownHostException e){
			System.err.println("Don't know about host " + hostname);
			System.exit(1);
		}catch(IOException e){
			System.err.println("Couldn't get I/O for the connection to" + hostname);
			System.exit(1);
		}

	}

	

}

class TCPClientThread  extends Thread {
	private Socket clientSocket = null;
 
    	TCPClientThread(Socket clientSocket) {
    		super("TCPClientThread");
    		this.clientSocket = clientSocket;
	
    	}
    	public void run() {
  		try{
			//input stream to read data
			BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
			while(true){
				String inputLine = in.readLine();
					while((inputLine != null) && !inputLine.isEmpty()){
						System.out.println("received from server: " + inputLine);
						inputLine = in.readLine();
					}
			}
  			
		}catch(IOException e){
			e.printStackTrace();
		}
		//clientSocket.close();
		
		
    	}
}
