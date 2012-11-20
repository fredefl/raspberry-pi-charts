// Load the TCP Library
net = require('net');

// An array containing all clients
var clients = [];

// --------------SETTINGS---------------
// The interval at which data will be collected and sent
var interval = 3000;

// The port to listen on
var port = 5000;

// The format to use; either 0 or 1
// 	0: JSON format
// 	1: Comma seperated format
var format = 0;

// Whenever to enable debug mode which will print useful messages to the console
var debug = true;
// -----------END OFSETTINGS------------

// Grab a command line!
var exec = require('child_process').exec;


// Start the TCP Server - this will also be run when a client connects
net.createServer(function (socket) {
	// If in debug mode, print a connection received message to the console
	if (debug) {
		console.log("New client connection from: " + socket.remoteAddress + ":" + socket.remotePort);
	}

	// Put this new client in the list and save it's id
	clients.push(socket);
	var clientId = clients.length;
	
	// Remove the client from the list when it disconnects
	socket.on('end', function () {
		// In in debug mode, print a disconnect message to the console
		if (debug) {
			console.log("Client disconnected");
		}	
		// Remove the client from the list
		clients.splice(clients.indexOf(socket), 1);
	});

	// If an error occurres
	socket.on('error', function () {
		// If in debug mode, print an error message to the console
		if (debug) {
			console.log("An error occurred, maybe a client disconnected without saying goodbye?");
		}

		// Loop through the client list and find the client we're dealing with
		for (var i = clients.length - 1; i >= 0; i--) {
			if (clients[i] === socket) {
				// Remove it from the list!
				clients.splice(i, 1);
			}
		};
		;
	});
}).listen(port); // Start listening

// Send a message to all clients
function broadcast(message) {
	// Loop through clients and send them the message
	clients.forEach(function (client) {
		try {
			client.write(message);
		} catch (e) {
			console.log("Error");
		}
	});
	// If debug mode is enabled, print message to command line
	if (debug) {
		console.log("Sent: " + message);
	}
}

// Gets and sends data to the client
function sendData () {
	// If there is one or more clients connected
	if (clients.length) {
		// Grab the needed information from the command line
		exec("ps aux|awk 'NR > 0 { s +=$3 }; END {print s}' && echo ',' && /opt/vc/bin/vcgencmd measure_temp", function (error, data) {
			// Split the result of the command line operation
			var parts = data.split(",");
			
			// Get the CPU part
			var cpu = parts[0].trim();
			
			// Get the temperature part
			var temperature = parts[1].replace(/[^0-9\.]+/g, "");
			
			// Initialize the message variable
			var message = ""; 
			
			// Find the format specified in the top
			switch (format) {
				case 0:
					// If zero, use JSON
					message = JSON.stringify({cpu: cpu, temperature: temperature});
					break;
				case 1:
					// If 1, use a comma seperated format
					message = cpu + "," + temperature;
					break;
				default:
					// If neither of the knows formats, throw an error
					message = "Wrong format specified";
					console.log("Wrong format specified");
					break;
			}

			// Send the message!
			broadcast(message);
		});
	};

	// Wait some time specified by the variable interval, and start all over again
	setTimeout(sendData, interval);
}

// Let the console know that we've started
console.log("Raspberry Pi Charts Server running at port " + port + "\n");

// Start the cycle
setTimeout(sendData, interval);