<style>
    /* Add some basic styling to the chatbox messages */
    #aiContainer{
        border: 1px solid grey;
        border-radius: 2px;
        padding: 10px;
        background-color: #101014;
    }
    #chatMessages {
        margin: 10px;
        overflow: auto;
        max-height: 300px;
        padding: 20px;
        position: relative;
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
    }

    .ai {
        background-color: #f0f0f0; /* Light gray for AI messages */
        margin-left: auto;
    }
    div#loadingSpinner{
        margin: 10px;
        width: fit-content;
        margin-left: auto;
    }
    div#loaderDiv{
        width: 85%;
    }
</style>


@extends('layouts.visitor.body')
@section('content')
    <div class="card">
        <div class="card-header" style="display:flex;justify-content:space-between">
            <p style="max-width:700px">Theme : <b> {{$selected->theme}} </b></p>
            <p> Date : <b>{{$selected->created_at}}</b></p>
        </div>
        <script>
            // Pass the selected to JavaScript variable
            const selected = @json($selected);
        </script>

        <script>
            // Pass the selected to JavaScript variable
            const apikey = @json($apikey);
        </script>


        <div class="card-body">
            <div> <!--Project Members-->
                <p style="color:#ff8400;">
                        <i class="fa-2x bi bi-people"></i>
                        <b style="position:relative;bottom:5px;left:5px;">{{$selected->members}}</b>
                </p>
            </div>
            <div> <!--Project Abstract-->
                <div style="display:flex;justify-content:space-between">
                    <h4>Abstract</h4>
                    <h5>Categorie : {{$selected->domaine}}</h5>
                </div>
                <div>

                    <p style="color:#798eb3;">
                        {{$selected->abstract}}
                    </p>
                </div>
            </div>
            <div> <!--PDF display-->
            <embed src="{{ asset("uploads/themes/$selected->theme/memoire/$selected->memoire_path") }}" type="application/pdf" width="100%" height="600px" >
            </div>
            <br>
            <br>
            <div> <!--Person a contacter-->
                <h4>Plus d'info ?</h4>
                <p>
                    <a href="mailto:{{$selected->chef_email}}">
                        <i class="bi bi-envelope-fill"></i> {{$selected->chef_email}}
                    </a>
                </p>
                <p>
                    <a href="mailto:{{$selected->encadreur_email}}">
                        <i class="bi bi-envelope-fill"></i> {{$selected->encadreur_email}}
                    </a>
                </p>
            </div>
                <div id="chatbox" class="mt-4">
                    <h4 style="text-align:center" >ResearchHub Ai</h4>
                    <p style="text-align:center">With <b> ResearchHubAi </b> Get more descriptive information based on the abstract here</p>
                    <!-- <div id="aiContainer">
                        <div id="chatMessages">

                            <div id="loadingSpinner" class="d-none">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="inputSection" style="display:grid;grid-template-columns:6fr 1fr;gap:10px;">

                            <input type="text" name="userInput" class="form-control" id="userInput">
                            <button type="submit" id="sendBtn" class="btn btn-primary">Send</button>
                        </div>
                    </div> -->
                    <div id="aiContainer">
                        <div id="chatMessages">


                        </div>
                        <div id="loaderDiv">
                        <div id="loadingSpinner" class="d-none">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="inputSection" style="display:grid;grid-template-columns:6fr 1fr;gap:10px;">

                            <input type="text" name="userInput" class="form-control" id="userInput">
                            <button type="submit" id="sendBtn" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
        </div>



        <div class="card-footer" style="display:flex;justify-content:space-between">
            <div>
                <h4>ResearchHub</h4>
            </div>
            <div class="social-linkss">
                <a href="whatsapp://send?text=Take a look at this project https://cof.camairetech.com/project/{{$selected->id}}" target="_blank">
                    <i class="fa-2x bi bi-whatsapp" style="color:#25D366"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?text=Take a look at this awesome project https://cof.camairetech.com/project/{{$selected->id}}" target="_blank">
                    <i class="fa-2x bi bi-twitter" style="color:#1DA1F2"></i>
                </a>
                <a href="https://t.me/share/url?url=https://cof.camairetech.com/project/{{$selected->id}}&text=Take a look at this awesome project" target="_blank">
                    <i class="fa-2x bi bi-telegram" style="color:#0088cc"></i>
                </a>
                <a href="https://facebook.com/sharer/sharer.php?u=https://cof.camairetech.com/project/{{$selected->id}}" target="_blank">
                    <i class="fa-2x bi bi-facebook" style="color:#1877f2"></i>
                </a>
            </div>
        </div>
    </div>
    <style>

    </style>

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
                messageDiv.textContent = text;
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            } else {
                messageDiv.classList.add("ai");
                const textSpan = document.createElement("span");
                messageDiv.appendChild(textSpan);
                const characters = text.split("");

                function typeNextCharacter(index) {
                    if (index < characters.length) {
                    textSpan.textContent += characters[index];
                    setTimeout(function() {
                        typeNextCharacter(index + 1);
                    }, 25);
                    }
                }
                typeNextCharacter(0);
                chatMessages.appendChild(messageDiv);
            }




        }

        function sendMessageToAI(prompt, projId) {
            // Use AJAX to send user input to the Laravel backend
            prompt =  userInput.value ;

            // Set up the GPT-3 API parameters
            const gpt3ApiUrl = 'https://api.openai.com/v1/chat/completions';
            const model = 'gpt-3.5-turbo';
            const role = 'user';
            // const apiKey = apiKey; // Replace with your actual GPT-3 API key

            // Create the message object
    //         const conversation = [
    //             { role: "system", content: `your discussin with a user Base on the following information I will provide you: ${selected.abstract}` },
    //             // { role: "system", content: `You are discussing the thesis with ID ${projId}.` },
    //             { role: "user", content: prompt }
    // ];

    const conversation = [
    { role: "system", content: `You are having a discussion about a research thesis on the topic: "${selected.theme}".` },
    { role: "system", content: `The abstract of the thesis is as follows: "${selected.abstract}".` },
    { role: "system", content: `The language of the thesis is: ${selected.language}.` },
    { role: "system", content: `The author(s) of the thesis are: ${selected.author}.` },
    { role: "system", content: `You can contact the researcher(s) at: ${selected.contact}.` },
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
                    "Authorization": `Bearer ${apikey}`
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
            sendMessageToAI(prompt, selected.projId);
            userInput.value = "";
        });
    });
</script>


@endsection

