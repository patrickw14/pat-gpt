<x-app-layout>
    <div class="flex h-screen">
        <!-- Sidebar (List of Conversations) -->
        <div class="w-1/4 bg-gray-800 text-white p-4 flex flex-col space-y-4 overflow-y-auto">
            <div class="flex flex-col space-y-2">
                @foreach ($conversations as $conversation)
	                <div>{{$conversation->title}}</div>
                @endforeach
            </div>
        </div>

        <!-- Chat Window -->
        <div class="flex-1 flex flex-col bg-gray-100">
            <!-- Chat Header -->
            <div class="bg-white p-4 shadow">
            <h2 class="text-xl font-semibold">Chat with Conversation 1</h2>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 p-4 space-y-4 overflow-y-auto">
            <!-- Example Message -->
            <div class="flex items-start">
                <div class="bg-blue-500 text-white p-3 rounded-lg max-w-xs">Hello!</div>
            </div>
            <div class="flex items-start justify-end">
                <div class="bg-gray-300 p-3 rounded-lg max-w-xs">Hi there!</div>
            </div>
            <!-- Add more messages as needed -->
            </div>

            <!-- Chat Input -->
            <div class="bg-white p-4 shadow">
                <div class="flex space-x-2">
                    <script>
                        console.log('TESTING');
                        document.getElementById('chatInput').addEventListener('input', function () {
                            this.style.height = 'auto'
                            this.style.height = this.scrollHeight + 'px'
                        })
                    </script>
                    <textarea id="chatInput" class="resize-none w-full p-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden" rows="1" placeholder="Type your message..."></textarea>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Send
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
