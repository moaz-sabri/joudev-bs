<main>
    <section>
        <div class="tab">
            <button class="tablinks" onclick="main.openCity(event, 'home')" id="defaultOpen">home</button>
            <button class="tablinks" onclick="main.openCity(event, 'about')">about</button>
            <button class="tablinks" onclick="main.openCity(event, 'contact')">contact</button>
        </div>

        <div id="home" class="tabcontent">
            <h3>home</h3>
        </div>

        <div id="about" class="tabcontent">
            <h3>about</h3>
        </div>

        <div id="contact" class="tabcontent">
            <h3>contact</h3>
        </div>
    </section>

    <section>
        <div id="myDIV" class="header">
            <h2 style="margin:5px">My To Do List</h2>
            <input type="text" id="myInput" placeholder="Title...">
            <span onclick="main.newElement()" class="addBtn">Add</span>
        </div>

        <ul id="myUL">
            <li>Hit the gym</li>
            <li class="checked">Pay bills</li>
            <li>Meet George</li>
            <li>Buy eggs</li>
            <li>Read a book</li>
            <li>Organize office</li>
        </ul>

    </section>
</main>
