#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netdb.h>
#include <strings.h>
#include <string.h>


int main(int argc, char *argv[])
{
	char *url;
	char *servername;
	char *filename;
	int port;
	int sockfd;
	char host[50];
	char path[50];
	char urlar[100];
	

	printf("Client program\n");
	if(argc != 2) {
		printf("Usage: %s <url>\n", argv[0]);
		exit(0);
	}

	url = argv[1];
	strncpy(urlar, url, 100);
	sscanf(urlar, "http://%[^/]/%s", host, path);
	filename = strrchr(urlar, '/') + 1;
	printf("Host = %s, Path = %s\n", host, path);

	sockfd = socket(AF_INET, SOCK_STREAM, 0);

	if(sockfd < 0 )
		perror("ERROR opening socket");

	struct hostent *server_he; //a host address entry
	
	if ((server_he = gethostbyname(host)) == NULL) {
		perror("error in gethostbyname");
		return 2;
	}

	//servername
	struct sockaddr_in serveraddr; //store the server's addr (declare), serveraddr is the variable name
	bzero((char *) &serveraddr, sizeof(serveraddr)); //clear sockaddr_in strucutre, this is simiilar to initalizing
	serveraddr.sin_family = AF_INET; //set the family to AF_INET (IPv4)

	//copy the server address from gethostbyname
	//return in struct hostent (stored in *server_he)
	bcopy((char *)server_he->h_addr, //the first host address
		(char *)&serveraddr.sin_addr.s_addr,
		server_he->h_length);

	
	//set the port number
	serveraddr.sin_port = htons(80);

	//connect: create a connection to the server
	if (connect(sockfd, (struct sockaddr * ) &serveraddr, 
		sizeof(serveraddr)) < 0){
		perror("Cannot connect to the server");
		exit(0);
	}else
		printf("Connected to the server");

	//send message
	char pathStr[100];
	char hostStr[100];
	sprintf(pathStr, "GET /%s HTTP/1.0\r\n", path); 
	sprintf(hostStr, "Host: %s \r\n\r\n", host);
	int path_bytes_sent;
	int host_bytes_sent;
	path_bytes_sent = send(sockfd, pathStr, strlen(pathStr), 0);
	host_bytes_sent = send(sockfd, hostStr, strlen(hostStr), 0);
	printf("\nMessage sent: %s", pathStr);

	//receive data
	char buffer[10000];
	int byte_received;
	int recv_count;
	bzero(buffer, 10000);
	
	byte_received = recv(sockfd, buffer, 10000, 0);
	if(byte_received < 0)
		error("ERROR reading from socket"); 
	printf("Message received: %s", buffer);

	//get response code
	char responseCode[10];
	sscanf(buffer, "HTTP/1.%*[01] %s", responseCode);
	
	//create output file
	if(strncmp("200", responseCode, 3) == 0){
		FILE *outfile;
		if(strlen(path) == 0){
			filename = "index.html";
			outfile = fopen(filename, "w+");
		}else{
			outfile = fopen(filename, "w+");
		}
		
		char *endOfHeader;
		endOfHeader = strstr(buffer, "\r\n\r\n");
		fwrite(endOfHeader+4, (byte_received-(endOfHeader-buffer+4)), 1, outfile); //write out non-header bytes from first receive
		
		while((recv_count=recv(sockfd, buffer, 10000, 0)) != 0){ //write out remaining bytes
			fwrite(buffer, recv_count, 1, outfile);
		
		}
		fclose(outfile);
	}else if(strncmp("301", responseCode, 3) == 0){
		printf("%s Moved Permanently", responseCode);
	}else if(strncmp("400", responseCode, 3) == 0){
		printf("%s Bad Request", responseCode);
	}else if(strncmp("404", responseCode, 3) == 0){
		printf("%s Not Found", responseCode);
	}else if(strncmp("505", responseCode, 3) == 0){
		printf("%s HTTP Version Not Supported", responseCode);
	}else{
		printf("%s Error", responseCode);
	}


	close(sockfd);

	return 0;
}
