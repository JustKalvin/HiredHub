<style>
    /* Floating Button */
    .hh-chat-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background-color: #172B4D;
        /* Warna Utama (Biru) */
        color: white;
        border-radius: 50%;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        cursor: pointer;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .hh-chat-btn:hover {
        transform: scale(1.1);
    }

    /* Chat Window */
    .hh-chat-window {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 350px;
        height: 450px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        opacity: 0;
        pointer-events: none;
        transform: translateY(20px);
        transition: all 0.3s ease;
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .hh-chat-window.active {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }

    /* Header */
    .hh-chat-header {
        background-color: #172B4D;
        color: white;
        padding: 15px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Messages Area */
    .hh-chat-messages {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background-color: #f3f4f6;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .message {
        max-width: 80%;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 14px;
        line-height: 1.4;
    }

    .message.user {
        align-self: flex-end;
        background-color: #172B4D;
        color: white;
        border-bottom-right-radius: 2px;
    }

    .message.bot {
        align-self: flex-start;
        background-color: #e5e7eb;
        color: #1f2937;
        border-bottom-left-radius: 2px;
    }

    /* Input Area */
    .hh-chat-input-area {
        padding: 10px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        background: white;
    }

    .hh-chat-input {
        flex: 1;
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        outline: none;
        font-size: 14px;
    }

    .hh-chat-send {
        background: transparent;
        border: none;
        color: #172B4D;
        margin-left: 10px;
        cursor: pointer;
        font-weight: bold;
    }

    .loading-dots {
        color: #6b7280;
        font-style: italic;
        font-size: 12px;
    }
</style>

<div id="hiredhub-chatbot-container">
    <div class="hh-chat-window" id="chatWindow">
        <div class="hh-chat-header">
            <span>HiredHub Assistant</span>
            <button onclick="toggleChat()" style="background:none;border:none;color:white;cursor:pointer;">✕</button>
        </div>
        <div class="hh-chat-messages" id="chatMessages">
            <div class="message bot">Halo! Ada yang bisa saya bantu terkait HiredHub?</div>
        </div>
        <form class="hh-chat-input-area" id="chatForm">
            <input type="text" id="chatInput" class="hh-chat-input" placeholder="Ketik pesan..." required
                autocomplete="off">
            <button type="submit" class="hh-chat-send">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
        </form>
    </div>

    <button class="hh-chat-btn" onclick="toggleChat()">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
    </button>
</div>

<script>
    const chatWindow = document.getElementById('chatWindow');
    const chatMessages = document.getElementById('chatMessages');
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');

    // Ganti URL ini jika sudah pindah ke Production (hapus -test)
    const N8N_WEBHOOK_URL = 'https://upoinwerf23t.app.n8n.cloud/webhook/hiredhub-chatbot';

    function toggleChat() {
        chatWindow.classList.toggle('active');
        if (chatWindow.classList.contains('active')) {
            chatInput.focus();
        }
    }

    function addMessage(text, sender) {
        const div = document.createElement('div');
        div.classList.add('message', sender);
        div.innerText = text;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight; // Auto scroll ke bawah
    }

    function addLoading() {
        const div = document.createElement('div');
        div.id = 'loadingIndicator';
        div.classList.add('message', 'bot', 'loading-dots');
        div.innerText = 'Mengetik...';
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function removeLoading() {
        const loading = document.getElementById('loadingIndicator');
        if (loading) loading.remove();
    }

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        // 1. Tampilkan pesan user
        addMessage(message, 'user');
        chatInput.value = '';
        addLoading();

        try {
            // 2. Kirim ke n8n
            // Note: Pastikan node 'Webhook' di n8n method-nya adalah POST
            const response = await fetch(N8N_WEBHOOK_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    chatInput: message,
                    sessionId: 'session-' + Math.random().toString(36).substr(2,
                        9) // Opsional: untuk memory
                })
            });

            const data = await response.json();

            removeLoading();

            // 3. Tampilkan balasan dari n8n
            // Asumsi: Output n8n json kamu memiliki key 'output' atau 'text'
            // Sesuaikan 'data.output' dengan struktur JSON return n8n kamu
            const botReply = data[0].output;
            addMessage(botReply, 'bot');

        } catch (error) {
            console.error('Error:', error);
            removeLoading();
            addMessage("Maaf, terjadi kesalahan pada server.", 'bot');
        }
    });
</script>
