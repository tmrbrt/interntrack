@extends('layouts.app')

@section('content')
<div class="d-flex flex-column min-vh-100"> <!-- Full-height container -->
    <div class="container mt-4 flex-grow-1"> <!-- Makes content expand naturally -->
        <h2 class="text-center fw-bold mb-4">Chat System</h2>

        <div class="row">
            <!-- User List Sidebar -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Users</h5>
                        <select id="role-filter" class="form-select form-select-sm w-auto">
                            <option value="">All Roles</option>
                            @foreach ($users->unique('role') as $user)
                                <option value="{{ $user->role }}">{{ ucfirst($user->role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body p-2">
                        <ul class="list-group" id="users-list">
                            @foreach($users->sortByDesc('unread_messages') as $user)
                                <li class="list-group-item list-group-item-action user" 
                                    data-id="{{ $user->id }}" 
                                    data-role="{{ $user->role }}" 
                                    data-unread="{{ $user->unread_messages }}" 
                                    style="cursor: pointer; font-weight: {{ $user->unread_messages > 0 ? 'bold' : 'normal' }};">
                                    
                                    {{ $user->name }} 
                                    <small class="text-muted">({{ ucfirst($user->role) }})</small>
                                    
                                    @if($user->unread_messages)
                                        <span class="badge bg-danger ms-2 unread-notification" id="unread-{{ $user->id }}">!</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Chat Box -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 id="chat-title" class="mb-0">Select a user to chat</h5>
                    </div>
                    <div class="card-body" style="height: 400px; overflow-y: auto;" id="messages">
                        <!-- Messages will be displayed here -->
                    </div>
                    <div class="card-footer">
                        <input type="hidden" id="receiver_id">
                        <div class="input-group">
                            <textarea id="message-input" class="form-control" placeholder="Type a message..."></textarea>
                            <button id="send-message" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let selectedUserId = null;

    document.querySelectorAll(".user").forEach(user => {
        user.addEventListener("click", function() {
            selectedUserId = this.getAttribute("data-id");
            document.getElementById("receiver_id").value = selectedUserId;
            document.getElementById("chat-title").innerText = "Chat with " + this.childNodes[0].nodeValue.trim();
            fetchMessages(selectedUserId);
            let notificationBadge = document.querySelector(`#unread-${selectedUserId}`);
            if (notificationBadge) {
                notificationBadge.style.display = "none";
            }
            markAsRead(selectedUserId);
        });
    });

    function markAsRead(userId) {
        fetch(`/chat/mark-as-read/${userId}`, {
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ userId: userId })
        });
    }

    function fetchMessages(userId) {
        fetch(`/chat/messages/${userId}`)
            .then(response => response.json())
            .then(messages => {
                let messagesDiv = document.getElementById("messages");
                messagesDiv.innerHTML = "";

                messages.forEach(msg => {
                    let isSender = msg.sender_id == {!! Auth::id() !!};
                    let messageClass = isSender ? 'bg-primary text-white ms-auto' : 'bg-light text-dark me-auto';
                    let senderName = isSender ? 'You' : 'User';

                    let messageElement = `<div class="d-flex flex-column mb-2">
                        <div class="p-2 rounded ${messageClass}" style="max-width: 75%;">
                            <strong>${senderName}:</strong> ${msg.message ? msg.message : ""}
                        </div>
                    </div>`;

                    messagesDiv.innerHTML += messageElement;
                });

                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            });
    }

    document.getElementById("send-message").addEventListener("click", function() {
        let message = document.getElementById("message-input").value.trim();
        let receiverId = document.getElementById("receiver_id").value;

        if (!receiverId) {
            alert("Please select a user to chat with.");
            return;
        }
        if (!message) {
            alert("Message cannot be empty.");
            return;
        }

        let formData = new FormData();
        formData.append("receiver_id", receiverId);
        formData.append("message", message);

        fetch("/chat/send", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            fetchMessages(receiverId);
            document.getElementById("message-input").value = "";
        })
        .catch(error => console.error("Error sending message:", error));
    });

    document.getElementById("role-filter").addEventListener("change", function() {
        let selectedRole = this.value;
        let users = document.querySelectorAll("#users-list .user");

        users.forEach(user => {
            let userRole = user.getAttribute("data-role");
            if (selectedRole === "" || userRole === selectedRole) {
                user.style.display = "block";
            } else {
                user.style.display = "none";
            }
        });
    });
});
</script>
@endsection
