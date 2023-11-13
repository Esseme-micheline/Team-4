<style>
    /* Add some basic styling to the chatbox messages */
    #chatMessages {
        margin-top: 10px;
        overflow-y: auto;
        max-height: 300px;
        border: 1px solid #ccc;
        padding: 10px;
    }

    .message {
        margin-bottom: 10px;
        padding: 5px 10px;
        border-radius: 8px;
        width: fit-content;
        max-width: 70%;
    }

    .user {
        background-color: #e6f7ff; /* Light blue for user messages */
        float: left;
    }

    .ai {
        background-color: #f0f0f0; /* Light gray for AI messages */
        float: right;
    }
</style>

@extends('layouts.visitor.body')
@section('content')

<div>
    <h1 class="text-primary" align="center">AI Side - AI Text Analysis</h1>

    <form method="POST" action="{{ route('visiteur.aiSearchMemoire') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="memoireId">Memoire ID</label>
                <input type="text" class="form-control" id="memoireId" placeholder="Enter the Memoire ID" name="projId">
            </div>
            <div class="form-group" style="padding:20px 0px;">
                <button type="submit" class="btn btn-primary">Search Memoire</button>
            </div>
        </div>
    </form>

    @if (isset($error))
        <div class="alert alert-danger mt-3">
            {{ $error }}
        </div>
    @endif

    @if (isset($projectInfo))
        <script>
            // Pass the projectInfo to JavaScript variable
            const projectInfo = @json($projectInfo);
        </script>

        <div class="project-info mt-3">
            <h2>Project Information</h2>
            <p><strong>Theme:</strong> {{ $projectInfo['theme'] }}</p>
            <p><strong>Authors:</strong> {{ $projectInfo['author'] }}</p>
            <p><strong>Contact:</strong> {{ $projectInfo['contact'] }}</p>
            <p><strong>Abstract:</strong> {{ $projectInfo['abstract'] }}</p>
            <p><strong>Language:</strong> {{ $projectInfo['language'] }}</p>
            <!-- Display other project information as needed -->
        </div>

        {{-- <h2>AI Analysis</h2> --}}
        <div id="chatbox" class="mt-4">
            <h2 style="align-item:center" >COF AI</h2>
            <div id="chatMessages"></div>
            <div id="loadingSpinner" class="d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="userInput">Your Message:</label>
                    <textarea class="form-control" id="userInput" name="userInput" rows="4" placeholder="Enter your message here"></textarea>
                </div>
                <div class="form-group" style="padding:20px 0px;">
                    <button type="button" id="sendBtn" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chatbox = document.getElementById("chatbox");
        const chatMessages = document.getElementById("chatMessages");
        const userInput = document.getElementById("userInput");
        const sendBtn = document.getElementById("sendBtn");

        // Function to append a message to the chatbox

        const loadingSpinner = document.getElementById("loadingSpinner");

        function showLoadingSpinner() {
            loadingSpinner.classList.remove("d-none");
        }

        function hideLoadingSpinner() {
            loadingSpinner.classList.add("d-none");
        }

        function appendMessage(text, isUser = false) {
            const messageDiv = document.createElement("div");
            messageDiv.classList.add("message");
            if (isUser) {
                messageDiv.classList.add("user");
            } else {
                messageDiv.classList.add("ai");
            }
            messageDiv.textContent = text;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function sendMessageToAI(prompt, projId) {
            // Use AJAX to send user input to the Laravel backend
            prompt =  userInput.value ;

            // Set up the GPT-3 API parameters
            const gpt3ApiUrl = 'https://api.openai.com/v1/chat/completions';
            const model = 'gpt-3.5-turbo';
            const role = 'user';
            const apiKey = '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'; // Replace with your actual GPT-3 API key

            // Create the message object
    //         const conversation = [
    //             { role: "system", content: `your discussin with a user Base on the following information I will provide you: ${projectInfo.abstract}` },
    //             // { role: "system", content: `You are discussing the thesis with ID ${projId}.` },
    //             { role: "user", content: prompt }
    // ];

    const conversation = [
    { role: "system", content: `You are having a discussion about a research thesis on the topic: "${projectInfo.theme}".` },
    { role: "system", content: `The abstract of the thesis is as follows: "${projectInfo.abstract}".` },
    { role: "system", content: `The language of the thesis is: ${projectInfo.language}.` },
    { role: "system", content: `The author(s) of the thesis are: ${projectInfo.author}.` },
    { role: "system", content: `You can contact the researcher(s) at: ${projectInfo.contact}.` },
    { role: "user", content: prompt }
];


            const messages = [{
                role: role,
                content: prompt
            }];

            // Make a POST request to the GPT-3 API
            fetch(gpt3ApiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${apiKey}`
                },
                body: JSON.stringify({
                    model: model,
                    messages: conversation
                }),
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                // Get the generated text from the API response
                const generatedText = data.choices[0].message.content;
                // Display AI response in the chatbox
                appendMessage(generatedText, false);
                hideLoadingSpinner();
            })
            .catch((error) => {
                console.log("Error of Json :", error);
                hideLoadingSpinner();
            });
        }

        // Show the chatbox when a thesis is found
        chatbox.style.display = "block";

        // Event listener for the Send button (in the chatbox)
        sendBtn.addEventListener("click", function() {
            const prompt = userInput.value;
            console.log("print");
            appendMessage(prompt, true);
            showLoadingSpinner(); // Show the loading spinner
            sendMessageToAI(prompt, projectInfo.projId);
            userInput.value = "";
        });
    });
</script>
@endsection
