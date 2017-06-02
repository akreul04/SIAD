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
		//System.out.println("Connected to the server\'" + hostName + "\'at port"
		
		//output stream to send data
		PrintWriter out = new PrintWriter(socket.getOutputStream(), true);
		//BufferedReader in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
		//buffer reade to read from user input
		BufferedReader stdIn = new BufferedReader(new InputStreamReader(System.in));
		new TCPClientThread(socket).start();
	
		System.out.println("Please enter a user name: ");
		userName = stdIn.readLine();
		out.println(userName + " has connected");
		

		while ((userInput = stdIn.readLine()) != null){
			out.println(userName + " says: " + userInput);

			if(userInput.equals("Get User List")){
				
			}
			

			if(userInput.equals("Exit")){
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
