<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spacey - NGO Chatbot</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Comic Sans MS', 'Chalkboard SE', 'Comic Neue', cursive;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
        }

        /* Blur Overlay - appears when chatbot opens */
        .blur-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            z-index: 999;
            display: none;
        }

        .blur-overlay.active {
            display: block;
        }

        /* Chat Container - positioned at bottom right */
        .chat-container {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 100%;
            max-width: 380px;
            height: 550px;
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            z-index: 1001;
            transform: scale(0);
            transition: transform 0.3s ease;
            border: 5px solid #FF9800;
        }

        .chat-container.active {
            transform: scale(1);
        }

        .chat-header {
            background: linear-gradient(135deg, #FF9800 0%, #FF6B00 100%);
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .bot-avatar {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .bot-name {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .close-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .close-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        .chat-messages {
            flex: 1;
            padding: 25px 20px;
            overflow-y: auto;
            background: #f5f5f5;
        }

        .message {
            margin-bottom: 20px;
            animation: slideIn 0.4s ease;
            clear: both;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .bot-message {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .bot-message .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #FF9800 0%, #FF6B00 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(255, 152, 0, 0.3);
        }

        .bot-message .bubble {
            background: white;
            padding: 14px 18px;
            border-radius: 20px;
            border-top-left-radius: 6px;
            max-width: 70%;
            box-shadow: 0 3px 8px rgba(0,0,0,0.12);
            border: 2px solid #FFE0B2;
        }

        .bot-message .label {
            font-weight: 700;
            color: #FF6B00;
            margin-bottom: 6px;
            font-size: 15px;
        }

        .bot-message .text {
            color: #444;
            line-height: 1.7;
            font-size: 15px;
        }

        .user-message {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .user-message .bubble {
            background: linear-gradient(135deg, #FF9800 0%, #FF6B00 100%);
            color: white;
            padding: 14px 18px;
            border-radius: 20px;
            border-top-right-radius: 6px;
            max-width: 70%;
            box-shadow: 0 3px 10px rgba(255, 107, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .user-message .text {
            line-height: 1.7;
            font-size: 15px;
            font-weight: 500;
        }

        .timestamp {
            font-size: 12px;
            color: #999;
            margin-top: 6px;
            text-align: right;
        }

        .chat-input-container {
            padding: 15px 20px;
            background: white;
            border-top: 1px solid #e0e0e0;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .chat-input {
            flex: 1;
            border: 2px solid #FFB74D;
            border-radius: 25px;
            padding: 14px 20px;
            font-size: 15px;
            font-family: 'Comic Sans MS', cursive;
            outline: none;
            transition: all 0.3s;
        }

        .chat-input:focus {
            border-color: #FF9800;
            box-shadow: 0 0 12px rgba(255, 152, 0, 0.2);
        }

        .send-btn {
            background: linear-gradient(135deg, #FF9800 0%, #FF6B00 100%);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(255, 152, 0, 0.4);
        }

        .send-btn:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 7px 20px rgba(255, 152, 0, 0.6);
        }

        .send-btn:active {
            transform: scale(0.95);
        }

        .floating-chat-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #FF9800 0%, #FF6B00 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(255, 152, 0, 0.5);
            transition: all 0.3s;
            z-index: 1000;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 8px 25px rgba(255, 152, 0, 0.5);
            }
            50% { 
                transform: scale(1.08);
                box-shadow: 0 12px 35px rgba(255, 152, 0, 0.7);
            }
        }

        .floating-chat-btn:hover {
            transform: scale(1.15) rotate(15deg);
            animation: none;
        }

        .hidden {
            display: none;
        }

        /* Child-friendly scrollbar */
        .chat-messages::-webkit-scrollbar {
            width: 10px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #FFE0B2;
            border-radius: 10px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #FF9800;
            border-radius: 10px;
            border: 2px solid #FFE0B2;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #FF6B00;
        }

        @media (max-width: 480px) {
            .chat-container {
                right: 10px;
                bottom: 90px;
                max-width: calc(100% - 20px);
                height: 500px;
            }

            .floating-chat-btn {
                right: 20px;
                bottom: 20px;
                width: 65px;
                height: 65px;
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <!-- Blur Overlay -->
    <div class="blur-overlay" id="blurOverlay" onclick="closeChat()"></div>

    <!-- Floating Chat Button -->
    <div class="floating-chat-btn" id="floatingBtn" onclick="openChat()">
        🤖
    </div>

    <!-- Chat Container -->
    <div class="chat-container" id="chatContainer">
        <div class="chat-header">
            <div class="header-left">
                <div class="bot-avatar">🤖</div>
                <div class="bot-name">Spacey</div>
            </div>
            <button class="close-btn" onclick="closeChat()">✕</button>
        </div>

        <div class="chat-messages" id="chatMessages"></div>

        <div class="chat-input-container">
            <input 
                type="text" 
                class="chat-input" 
                id="userInput" 
                placeholder="Write a message..."
                onkeypress="handleKeyPress(event)"
            >
            <button class="send-btn" onclick="sendMessage()">▶</button>
        </div>
    </div>

    <script>
        let step = 0;
        let data = {
    first_name: "",
    middle_name: "",
    last_name: "",
    email: "",
    phone: "",
    child_name: "",
    child_age: "",
    child_gender: "",
    parent_query: ""
};
function capitalizeWords(str) {
    return str
        .toLowerCase()
        .replace(/\b\w/g, char => char.toUpperCase());
}



        const questions = [
    "What is your first name? 😊",
    "What's your middle name? ⭐ (optional)",
    "And your last name? ✨",
    "What's your email address? 📧",
    "What's your phone number? 📱",
    "What is your child's name? 👶",   //  ADDED
    "How old is your child? 🎂",
    "What is your child's gender? (Male/Female/Other)",
    "Please write your query here! 💭"
];


        const keys = [
    "first_name",
    "middle_name",
    "last_name",
    "email",
    "phone",
    "child_name",      //  ADDED
    "child_age",
    "child_gender",
    "parent_query"
];


        function openChat() {
            const chatContainer = document.getElementById('chatContainer');
            const floatingBtn = document.getElementById('floatingBtn');
            const blurOverlay = document.getElementById('blurOverlay');
            
            chatContainer.classList.add('active');
            floatingBtn.classList.add('hidden');
            blurOverlay.classList.add('active');
            
            if (step === 0) {
                setTimeout(() => {
                    addBotMessage("Hello! 👋 I am Spacey and I will help you for understanding the application functionality. Let's start! 🌟");
                    setTimeout(() => {
                        addBotMessage(questions[0]);
                    }, 1000);
                }, 400);
            }
        }

        function closeChat() {
            const chatContainer = document.getElementById('chatContainer');
            const floatingBtn = document.getElementById('floatingBtn');
            const blurOverlay = document.getElementById('blurOverlay');
            
            chatContainer.classList.remove('active');
            floatingBtn.classList.remove('hidden');
            blurOverlay.classList.remove('active');
        }

        function addBotMessage(text) {
            const messagesDiv = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message bot-message';
            
            const time = new Date().toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            messageDiv.innerHTML = `
                <div class="avatar">🤖</div>
                <div>
                    <div class="bubble">
                        <div class="label">Spacey</div>
                        <div class="text">${text}</div>
                    </div>
                    <div class="timestamp">${time}</div>
                </div>
            `;
            
            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function addUserMessage(text) {
            const messagesDiv = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message user-message';
            
            const time = new Date().toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            messageDiv.innerHTML = `
                <div>
                    <div class="bubble">
                        <div class="text">${text}</div>
                    </div>
                    <div class="timestamp">${time}</div>
                </div>
            `;
            
            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function sendMessage() {
    const input = document.getElementById('userInput');
    const msg = input.value.trim();

    if (!msg) return;

    // ✅ Email validation
if (keys[step] === "email") {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(msg)) {
        addBotMessage("⚠️ Please enter a valid email address.");
        return;
    }
}


// ✅ Phone number validation
if (keys[step] === "phone") {
    if (!/^\d{10}$/.test(msg)) {
        addBotMessage("⚠️ Please enter a valid 10-digit phone number.");
        return;
    }
}


    // ✅ Age validation
    if (keys[step] === "child_age") {
        const age = parseInt(msg);
        if (isNaN(age) || age < 1 || age > 18) {
            addBotMessage("⚠️ Please enter a valid child age between 1 and 18.");
            return;
        }
    }

    // ✅ Gender validation
    if (keys[step] === "child_gender") {
        const valid = ["male","female","other"];
        if (!valid.includes(msg.toLowerCase())) {
            addBotMessage("⚠️ Please type Male, Female, or Other.");
            return;
        }
    }

    addUserMessage(msg);

// ✅ Auto-capitalize names
if (["first_name", "middle_name", "last_name", "child_name"].includes(keys[step])) {
    data[keys[step]] = capitalizeWords(msg);
} else {
    data[keys[step]] = msg;
}

input.value = '';
step++;


    setTimeout(() => {
        if (step < questions.length) {
            addBotMessage(questions[step]);
        } else {
            saveData();
        }
    }, 700);
}


        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        function saveData() {
    fetch('api/chatbot.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result && result.status === "error") {
            addBotMessage("⚠️ " + result.message);
        } else {
            addBotMessage("✅ Thank you so much! 🙏✨ We will contact you very soon! Have a great day! 🌈");
        }
    })
    .catch(error => {
        console.error(error);
        addBotMessage("⚠️ Something went wrong. Please try again later.");
    });
}

    </script>
</body>
</html>