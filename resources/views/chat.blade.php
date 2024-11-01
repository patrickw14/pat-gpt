<x-app-layout >
    <div class="flex h-screen" x-data="chatComponent()" x-init="initialize()">
        <!-- Sidebar (List of Conversations) -->
        <div class="w-64 bg-gray-800 text-white p-4 flex flex-col space-y-4 overflow-y-auto">
            <div class="flex flex-col space-y-2">
                @foreach ($conversations as $conversation)
                    <a href="{{ url('/chat/' . $conversation->id) }}" class="block p-2 hover:bg-gray-700 rounded {{ request()->is('chat/' . $conversation->id) ? 'bg-gray-700' : '' }}">
                        {{$conversation->title}}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Chat Window -->
        <div class="flex-1 flex flex-col bg-gray-100">
            <!-- Chat Header -->
            <div class="bg-white p-4 shadow">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Chat with {{ $selectedConversation->title }}</h2>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:underline">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 p-4 space-y-4 overflow-y-auto" id="chatWindow" x-ref="chatWindow">
                    <template x-for="message in messages" :key="message.id">
                        <div :class="message.type === 'user' ? 'justify-end' : 'justify-start'" class="flex items">
                            <div :class="message.type === 'system'  ? 'bg-blue-500 text-white' : 'bg-gray-300'" class="p-3 rounded-lg max-w-xs"><span x-text="message.content"></span></div>
                        </div>
                    </template>
            </div>

            <!-- Chat Input -->
            <div class="bg-white pt-4 pb-2 px-4 shadow">
                <div class="flex space-x-2">
                    <textarea 
                        x-model="messageContent" 
                        @keydown.enter="sendMessage()"
                        id="chatInput" 
                        class="resize-none w-full p-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden" 
                        rows="1" 
                        placeholder="Type your message..."></textarea>
                    <button @click="sendMessage" id="sendButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Send
                    </button>
                </div>
            </div>

            <div class="bg-white text-center text-gray-500 text-xs pb-2">
                PatGPT never makes mistakes. Don't bother checking important info.
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function generateUniqueId() {
        return Date.now();
    }

    function chatComponent() {
        const selectedConversation = @json($selectedConversation);
        return {
            messages: @json($messages),
            messageContent: '',
            initialized: false,
            initialize() {
                this.scrollToBottom();

                window.Echo.private(`chat.${selectedConversation.id}`).listen("SystemMessageChunkCreated", (event) => {
                    const existingMessage = this.messages.find(message => message.id === event.messageId);
                    if (existingMessage) {
                        existingMessage.content += event.chunk;
                    } else {
                        this.messages.push({
                            id: event.messageId,
                            content: event.chunk,
                            conversation_id: @json($selectedConversation).id,
                            type: 'system',
                            created_at: new Date().toISOString(),
                            updated_at: new Date().toISOString()
                        });
                    }
                    this.scrollToBottom();
                });
            },
            pushMessage(message) {
                const chatWindow = this.$refs.chatWindow;
                const isScrolledToBottom = chatWindow.scrollHeight - chatWindow.clientHeight <= chatWindow.scrollTop + 1;

                this.messages.push(message);
                if (isScrolledToBottom) {
                    this.scrollToBottom();
                }
            },
            sendMessage() {
                if (this.messageContent.trim() === '') {
                    return;
                }

                fetch(`/chat/${selectedConversation.id}/message`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ content: this.messageContent })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        this.messageContent = '';
                        this.pushMessage({
                            id: generateUniqueId(),
                            content: data.message,
                            conversation_id: @json($selectedConversation).id,
                            type: 'user',
                            created_at: new Date().toISOString(),
                            updated_at: new Date().toISOString()
                        })
                    }
                })
                .catch(error => console.error('Error:', error));
            },
            scrollToBottom() {
                this.$nextTick(() => {
                    const chatWindow = this.$refs.chatWindow;
                    chatWindow.scrollTop = chatWindow.scrollHeight;
                    this.initialized = true;
                })
            }
        }
    }
</script>

