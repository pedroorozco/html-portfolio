// Code below will transition the page after login
function login(event) {
    // Preventing default form action
    event.preventDefault();


    var userEmail = "test@gmail.com";
    var userPassword = "test";

    var enteredEmail = document.getElementById("email").value;
    var enteredPassword = document.getElementById("password").value;
    var passwordConfirmation = document.getElementById("confirm-password").value;

    if (userEmail !== enteredEmail) {
        window.alert("Wrong Email Entered, Try Again");
    } else if (userPassword !== enteredPassword) {
        window.alert("Incorrect Password, Try Again");
    }else if (userPassword !== passwordConfirmation) {
        window.alert("Incorrect Password, Try Again");
    } else {
        document.querySelector(".right-info").style.display = "none";
        document.getElementById("chatbotContainer").style.display = "block";
    }

    // Set focus on Message Box
    document.getElementById("userInput").focus();
}

// Simple chatbot logic with message limit of 20
var messageCount = 0;

function sendMessage() {
    var userInput = document.getElementById("userInput").value;
    var chatContainer = document.getElementById("chat");

    // Display user's message
    chatContainer.innerHTML += "<div class='user-message'><strong>User</strong>: " + userInput + "</div>";

    // Hard Coding specific responses when user gives specific input. All other input bot will repeat input back
    if (userInput == "Hello") {
        chatContainer.innerHTML += "<div class='chatbot-message'><strong>Draven</strong>: Who wants some Draven? Heheheh</div>";
    } else if (userInput == "Are you number 1?") {
        chatContainer.innerHTML += "<div class='chatbot-message'><strong>Draven</strong>: Perfection? I got that</div>";        
    } else {
        chatContainer.innerHTML += "<div class='chatbot-message'><strong>Draven</strong>: " + userInput + "</div>";
    }


    // Clear the user input field
    document.getElementById("userInput").value = "";

    // Increment count
    messageCount++;

    // Check to make sure we dont go over 20 messages. Also adding some random messages
    if (messageCount == 5) {
        // Unique taunt
        chatContainer.innerHTML += "<div class='chatbot-message'><strong>Draven</strong>: Let\'s admire me for a bit.</div>";
    } else if (messageCount == 10) {
        chatContainer.innerHTML += "<div class='chatbot-message'><strong>Draven</strong>: <i>Draven laughs maniacally</i></div>";
    } else if (messageCount == 15) {
        chatContainer.innerHTML += "<div class='chatbot-message'><strong>Draven</strong>: I have the best job</div>";
    } else if (messageCount >= 20) {
        // Resetting chat logs
        chatContainer.innerHTML = "<div><strong>Draven Bot</strong>: Logs have been cleansed.</div>";

        // Reset message counter
        messageCount = 0;
    }

    // Setting focus back to user input textbox
    document.getElementById("userInput").focus();
}

function sendWithEnter(event) {
    // Check if Enter key is used to send message
    if (event.key === "Enter") {
        sendMessage();
    }
}