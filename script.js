function restoreCurrentPage() {
    const topicGroup = localStorage.getItem('topicGroup');
    const topic = localStorage.getItem('topic');

    if (topicGroup == undefined && topic == undefined) {
        return;
    }

    else if (topicGroup != undefined && topic == undefined) {
        jumpTo(topicGroup);
    }

    else {
        openTopic(topic);
    }

}
restoreCurrentPage();
// <--- �������������� ������ --->

function jumpTo(idTopicGroup) {
    $("#searchbar").html("");
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const topics = JSON.parse(this.responseText);

            let renderedHTML = "";

            topics.forEach((topic) => {
                console.log(topic);
                renderedHTML += `
                    <div class='topic' onclick=openTopic('${topic.ID_TOPIC}')>
                        <div class='topic-head'>
                            ${topic.TOPIC_NAME}
                        </div>
                        <div class='topic-author'>
                        </div>
                        <div class='topic-date-of-creation'>
                            Создана: ${topic.CREATION_DATE}
                        </div>
                    </div>
                `
            });
            if (topics.length == 0) {
                renderedHTML = "<a class='no-threads'>Увы... Пока ничего нет</a>";
            }

            $("#topics-container").html("");
            $("#topics-container").append(renderedHTML);
        }
    };

    localStorage.removeItem('topic');
    localStorage.setItem('topicGroup', idTopicGroup);

    xmlhttp.open("GET", "action/show_topics.php?idtopicgroup=" + idTopicGroup, true);
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xmlhttp.send();

}

function postMessage(idTopic) {

    var xmlhttp = new XMLHttpRequest();

    const message =    $("#msg").val();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            openTopic(idTopic);
            console.log(this.responseText);
            window.scrollTo(0, document.body.scrollHeight);
        }
    };

    var form = new FormData();
    form.append("id_topic", idTopic);
    form.append("message", message);
    console.log(form);

    xmlhttp.open("POST", "action/post_message.php", true);

    xmlhttp.send(form);
}

function openTopic(idTopic) {
    const htmlMessagePost = `
    <div class="msg-form">
        <label class="msg-label" for="msg">Ваше сообщение:</label><br>
        <textarea class="msg-area" rows="5" cols="50" id="msg" name="msg"></textarea><br>
        <button onclick="postMessage(${idTopic})">Отправить</button>
    </div>
    `;

    $("#searchbar").html("");
    $("#searchbar").append(htmlMessagePost);
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const messages = JSON.parse(this.responseText);
            console.log(messages);
            let renderedHTML = "";

            messages.forEach((msg) => {
                renderedHTML += `
                <div class='message')>
                    <a><img src="action/template/avatar.php?user='${msg.ID_USER}'"></a>
                    <div class='message-author' style='color:${msg.UNIQUE_COLOR}'>
                        ${msg.NAME} ${msg.PSEUDONAME}
                    </div>
                    <div class='message-date'>
                        оставил сообщение в ${msg.PUBLISH_DATE}
                    </div>
                    <div class='message-content'>
                        ${msg.CONTENT}
                    </div>
                </div>
                `
            });

            if (messages.length == 0) {
                renderedHTML = "<a class='no-threads'>Пока нет сообщений. Станьте первым!</a>";
            }


            $("#topics-container").html("");
            $("#topics-container").append(renderedHTML);
        }
    };

    xmlhttp.open("GET", "action/open_topic.php?idtopic=" + idTopic, true);
    localStorage.setItem('topic', idTopic);
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xmlhttp.send();

}
function fetch_user() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const user_info = this.responseText;
            sessionStorage['user'] = user_info;
        }
    };
    xmlhttp.open("GET", "action/fetch_user.php", true);
    xmlhttp.send();
}

function logout() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var login_form = `
            <div class="auth-mini-window">
            <div class="no-auth">
            <a>Вы не авторизованы</a>
            </div>
            <label class="auth-labels" for="login">Логин:</label>
            <input class="auth-field" type="text" id="login" name="login" />
            <label class="auth-labels" for="password">Пароль:</label>
            <input class="auth-field" type="password" id="password" name="password" />
            <button onclick="signin()">Войти</button>
            <button onclick="signup_open()">Регистрация</button>
            <button onclick="recover_password_open()">Забыли пароль?</button>
            </div>`;

            $("#auth-status").html("");
            $("#auth-status").append(login_form);
            sessionStorage.removeItem('user');
            $("#topics-container").html("");
            $("#searchbar").html("");
        }
    };
    xmlhttp.open("GET", "action/logout.php", true);
    xmlhttp.send();
}

function signin() {
    var xmlhttp = new XMLHttpRequest();

    const login =       $("#login").val();
    const password =    $("#password").val();

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const answer = JSON.parse(this.responseText);
            if (answer.AUTH_STATUS == true) {
                console.log("Авторизация завершена");
                fetch_user();

                const name = answer.PSEUDONAME;

                var register_form = `
                <div class="auth-mini-window">
                    <a href=''><img src="action/template/avatar.php?user='${answer.ID_USER}'"></a>
                    <a>Добро пожаловать, ${name} </a>
                    <button onclick='logout()'>Выйти</button>
                </div>'`;

                $("#auth-status").html("");
                $("#auth-status").append(register_form);
            }
            else {
                console.log("Авторизация безуспешна");
            }
        }
    };

    var form = new FormData();
    form.append("login", login);
    form.append("pass", password);

    xmlhttp.open("POST", "action/signin.php", true);

    xmlhttp.send(form);
}


function signup_open() {
    var register_form = `
    <div class="auth-mini-window">
        <label class="auth-labels" for="login">Логин:</label>
        <input class="auth-field" type="text" id="login" name="login" />

        <label class="auth-labels" for="password">Пароль:</label>
        <input class="auth-field" type="password" id="password" name="password" />

        <label class="auth-labels" for="email">E-Mail:</label>
        <input class="auth-field" type="email" id="email" name="email" />

        <label class="auth-labels" for="pseudoname">Ник (отображается на сайте):</label>
        <input class="auth-field" type="text" id="pseudoname" name="pseudoname" />

        <label class="auth-labels" for="avatar">Аватар:</label>
        <input type="file" name="avatar" id="avatar"/>

        <button onclick="signup()">Зарегистрироваться</button>
    </div>'`;


    $("#auth-status").html("");
    $("#auth-status").append(register_form);
}

function recover_password_open() {
    var recover_form = `
    <div class="auth-mini-window">
        Восстановление пароля
        <label class="auth-labels" for="email">E-Mail:</label>
        <input class="auth-field" type="email" id="email" name="email" />

    <button onclick="recover_password()">Восстановить</button>
    </div>'`;


    $("#auth-status").html("");
    $("#auth-status").append(recover_form);
}

function signup() {

    const file_field = document.querySelector('#avatar');

    const login =           $("#login").val();
    const password =        $("#password").val();
    const email =           $("#email").val();
    const pseudoname =      $("#pseudoname").val();
    const file =            file_field.files[0];


    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);

        }
    };


    var form = new FormData();
    form.append("file", file);
    form.append("login", login);
    form.append("password", password);
    form.append("email", email);
    form.append("pseudoname", pseudoname);

    xmlhttp.open("POST", "action/signup.php", true);

    xmlhttp.send(form);
}

function recover_password() {

    const email =           $("#email").val();

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };


    var form = new FormData();

    form.append("email", email);

    xmlhttp.open("POST", "action/recover_password.php", true);

    xmlhttp.send(form);
}


