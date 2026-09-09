<!-- I Kan AI Concierge Chatbot -->
<div id="ikan-chatbot-container">
    <div id="chatbot-toggle" class="chatbot-bubble">
        <div class="bubble-content">
            <i class="fa-solid fa-robot"></i>
        </div>
        <div class="notification-dot"></div>
    </div>

    <!-- Chat Window -->
    <div id="chatbot-window" class="chatbot-window-hidden">
        <div class="chatbot-header">
            <div class="bot-info">
                <div class="bot-avatar">
                   <img src="/ikanhousing-final/img/Ikanhousing-logo2.svg" alt="Ikan Bot" style="width: 25px; filter: brightness(0) invert(1);">
                </div>
                <div class="bot-details">
                    <h6>I Kan Concierge</h6>
                    <span class="status-online">Online</span>
                </div>
            </div>
            <button id="close-chatbot" class="close-btn">&times;</button>
        </div>

        <div id="chatbot-messages" class="chatbot-messages">
            <!-- Messages will be injected here -->
        </div>

        <div id="chatbot-input-area" class="chatbot-input-area">
            <div id="chatbot-options" class="chatbot-options-container">
                <!-- Quick options will be injected here -->
            </div>
            <div class="input-wrapper" id="text-input-wrapper" style="display: none;">
                <input type="text" id="chatbot-user-input" placeholder="Type your message...">
                <button id="send-chatbot-msg"><i class="fa-solid fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
</div>

<style>
/* Chatbot Styles */
#ikan-chatbot-container {
    position: fixed;
    bottom: 105px;
    right: 30px;
    z-index: 10000;
    font-family: 'Outfit', sans-serif;
}

.chatbot-bubble {
    width: 60px;
    height: 60px;
    background: #c02a7c;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 10px 25px rgba(192, 42, 124, 0.4);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    border: 2px solid white;
}

.chatbot-bubble:hover {
    transform: translateY(-5px) scale(1.05);
}

.bubble-content {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.notification-dot {
    position: absolute;
    top: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    background: #FFD700;
    border-radius: 50%;
    border: 2px solid #c02a7c;
    animation: pulse-dot 2s infinite;
}

@keyframes pulse-dot {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

/* Window Styles */
#chatbot-window {
    position: absolute;
    bottom: 70px;
    right: 0;
    width: 350px;
    height: 500px;
    max-height: 80vh;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 15px 45px rgba(0,0,0,0.15);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: all 0.4s ease;
    transform-origin: bottom right;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.chatbot-window-hidden {
    opacity: 0;
    visibility: hidden;
    transform: scale(0.8) translateY(20px);
    pointer-events: none;
}

.chatbot-header {
    background: linear-gradient(135deg, #2d0a1c 0%, #c02a7c 100%);
    padding: 20px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bot-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.bot-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bot-details h6 {
    margin: 0;
    font-weight: 700;
    font-size: 16px;
}

.status-online {
    font-size: 11px;
    color: #4ade80;
    display: flex;
    align-items: center;
    gap: 4px;
}

.status-online::before {
    content: '';
    width: 6px;
    height: 6px;
    background: #4ade80;
    border-radius: 50%;
}

.close-btn {
    background: none;
    border: none;
    color: rgba(255,255,255,0.7);
    font-size: 24px;
    cursor: pointer;
    transition: color 0.2s;
}

.close-btn:hover { color: white; }

.chatbot-messages {
    flex-grow: 1;
    padding: 20px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* Message Bubbles */
.msg {
    max-width: 85%;
    padding: 10px 15px;
    border-radius: 15px;
    font-size: 14px;
    line-height: 1.5;
    position: relative;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.msg-bot {
    align-self: flex-start;
    background: #f1f5f9;
    color: #334155;
    border-bottom-left-radius: 2px;
}

.msg-user {
    align-self: flex-end;
    background: #c02a7c;
    color: white;
    border-bottom-right-radius: 2px;
}

.typing-indicator {
    padding: 10px 15px;
    background: #f1f5f9;
    border-radius: 15px;
    width: fit-content;
    display: flex;
    gap: 4px;
}

.dot {
    width: 6px;
    height: 6px;
    background: #cbd5e1;
    border-radius: 50%;
    animation: bounce 1.4s infinite;
}

.dot:nth-child(2) { animation-delay: 0.2s; }
.dot:nth-child(3) { animation-delay: 0.4s; }

@keyframes bounce {
    0%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-6px); }
}

/* Input Area */
.chatbot-input-area {
    padding: 15px;
    background: white;
    border-top: 1px solid #f1f5f9;
}

.chatbot-options-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 5px;
}

.chat-opt {
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #e2e8f0;
    padding: 8px 14px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.chat-opt:hover {
    background: #c02a7c;
    color: white;
    border-color: #c02a7c;
}

.input-wrapper {
    display: flex;
    gap: 10px;
    align-items: center;
}

.input-wrapper input {
    flex-grow: 1;
    border: 1px solid #e2e8f0;
    padding: 10px 15px;
    border-radius: 10px;
    font-size: 14px;
    outline: none;
}

.input-wrapper input:focus { border-color: #c02a7c; }

.input-wrapper button {
    background: #c02a7c;
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    cursor: pointer;
}

@media (max-width: 480px) {
    #chatbot-window {
        width: calc(100vw - 40px);
        right: -10px;
        bottom: 70px;
    }
}
</style>

<script>
$(document).ready(function() {
    const chatbotToggle = $('#chatbot-toggle');
    const chatbotWindow = $('#chatbot-window');
    const closeChatbot = $('#close-chatbot');
    const messagesContainer = $('#chatbot-messages');
    const optionsContainer = $('#chatbot-options');
    const inputWrapper = $('#text-input-wrapper');
    const userInput = $('#chatbot-user-input');
    const sendBtn = $('#send-chatbot-msg');

    let currentStep = 0;
    let leadData = {
        name: '',
        phone: '',
        service: '',
        page: window.location.pathname
    };

    // Toggle Chat
    chatbotToggle.on('click', () => {
        chatbotWindow.toggleClass('chatbot-window-hidden');
        if (!chatbotWindow.hasClass('chatbot-window-hidden') && messagesContainer.children().length === 0) {
            startConversation();
        }
    });

    closeChatbot.on('click', () => chatbotWindow.addClass('chatbot-window-hidden'));

    function addBotMessage(text, delay = 1000) {
        const typing = $('<div class="typing-indicator"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>');
        messagesContainer.append(typing);
        scrollToBottom();

        setTimeout(() => {
            typing.remove();
            messagesContainer.append(`<div class="msg msg-bot">${text}</div>`);
            scrollToBottom();
        }, delay);
    }

    function addUserMessage(text) {
        messagesContainer.append(`<div class="msg msg-user">${text}</div>`);
        scrollToBottom();
    }

    function scrollToBottom() {
        messagesContainer.animate({ scrollTop: messagesContainer[0].scrollHeight }, 300);
    }

    function startConversation() {
        addBotMessage("Hi there! 👋 Welcome to I Kan Housing. I'm your AI Concierge.");
        setTimeout(() => {
            addBotMessage("How can I assist you today? Please choose an option below:");
            showOptions(["🏠 Residential Projects", "🏢 Commercial Leasing", "💼 Career Options", "📞 Other Inquiry"]);
        }, 1500);
    }

    function showOptions(opts) {
        optionsContainer.empty().show();
        inputWrapper.hide();
        opts.forEach(opt => {
            const btn = $(`<button class="chat-opt">${opt}</button>`);
            btn.on('click', () => handleOptionClick(opt));
            optionsContainer.append(btn);
        });
    }

    function handleOptionClick(opt) {
        addUserMessage(opt);
        leadData.service = opt;
        optionsContainer.hide();
        
        setTimeout(() => {
            addBotMessage("That's great! I'd love to help with that. Could you please tell me your **Full Name**?");
            inputWrapper.css('display', 'flex');
            currentStep = 1; // Expecting Name
        }, 1000);
    }

    sendBtn.on('click', () => processInput());
    userInput.on('keypress', (e) => { if(e.which == 13) processInput(); });

    function processInput() {
        const val = userInput.val().trim();
        if(!val) return;

        userInput.val('');
        addUserMessage(val);

        if(currentStep === 1) {
            leadData.name = val;
            setTimeout(() => {
                addBotMessage(`Nice to meet you, ${val}! Finally, please share your **Mobile Number** so our expert can reach out.`);
                currentStep = 2; // Expecting Phone
            }, 1000);
        } else if(currentStep === 2) {
            if(!/^\d{10}$/.test(val.replace(/\D/g,''))) {
                setTimeout(() => addBotMessage("Oops! That doesn't look like a valid 10-digit mobile number. Please try again."), 500);
                return;
            }
            leadData.phone = val;
            saveLead();
        }
    }

    function saveLead() {
        inputWrapper.hide();
        setTimeout(() => {
            addBotMessage("Perfect! I'm sending your request to our team right now... 🚀");
            
            $.post('/ikanhousing-final/api/chatbot-api.php', leadData, function(response) {
                setTimeout(() => {
                    if(response.status === 'success') {
                        addBotMessage("Thank you! Your inquiry has been received. Our expert will call you shortly today.");
                    } else {
                        addBotMessage("Thanks for sharing! We've noted your interest and our team will get back to you.");
                    }
                }, 1500);
            }, 'json');
        }, 1200);
    }
});
</script>
