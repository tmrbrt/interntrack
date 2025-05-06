document.addEventListener("DOMContentLoaded", function () {
    // Wait until Pusher is loaded
    if (typeof Pusher === "undefined") {
        console.error("❌ Pusher is not loaded. Make sure the script is included correctly.");
        return;
    } else {
        console.log("✅ Pusher loaded successfully.");
    }

    // Initialize Pusher
    const pusher = new Pusher("YOUR_PUSHER_KEY", {
        cluster: "YOUR_PUSHER_CLUSTER",
        encrypted: true
    });

    let selectedStudent = null;

    document.querySelectorAll(".open-chat").forEach(button => {
        button.addEventListener("click", function () {
            selectedStudent = this.getAttribute("data-student-id");
            document.getElementById("chatStudentName").textContent = this.getAttribute("data-student-name");
            loadMessages(selectedStudent);
        });
    });

    document.getElementById("send-message").addEventListener("click", function () {
        let message = document.getElementById("chat-message").value;
        if (selectedStudent && message.trim() !== "") {
            axios.post("/messages", {
                receiver_id: selectedStudent,
                message: message
            }).then(response => {
                document.getElementById("chat-message").value = "";
                appendMessage(response.data.message.message, "You");
            }).catch(error => {
                console.error("Error sending message", error);
            });
        }
    });

    function loadMessages(studentId) {
        axios.get(`/messages/${studentId}`).then(response => {
            let chatBox = document.getElementById("chat-box");
            chatBox.innerHTML = "";
            response.data.forEach(msg => {
                appendMessage(msg.message, msg.sender_id === parseInt(studentId) ? "Student" : "You");
            });
        });
    }

    function appendMessage(message, sender) {
        let chatBox = document.getElementById("chat-box");
        chatBox.innerHTML += `<p><strong>${sender}:</strong> ${message}</p>`;
        chatBox.scrollTop = chatBox.scrollHeight;
    }
});
