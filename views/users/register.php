<style>
    html, body {
        height: 100%;
        width: 100%;
        margin: 0;
    }

    body {
        display: flex;
        background-color: #f5f9ff;
    }

    .register-container {
        margin: auto;
    }

    .register-container form {
        display: flex;
        flex-direction: column;
        row-gap: 1rem;
    }

    .register-container input {
        padding: 10px;
        border: none;
        font-size: 18px;
    }

    .register-container label {
        width: 100%;
        text-align: right;
        display: inline-block;
        font-size: 18px;
    }

    .register-container .btn-container {
        text-align: right;
    }

    .register-container .btn {
        background-color: #00a3c2;
        border: none;
        padding: 10px;
        font-size: 18px;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        width: 76%;
    }

    .register-container .btn:hover {
        background-color: #01cef3;
    }
</style>
<div class="register-container">
    <form action="/users" method="post">
        <div>
            <label>
                Name:
                <input type="text" name="name" placeholder="John Smith" />
            </label>
        </div>
        <div>
            <label>
                Email:
                <input type="email" name="email" placeholder="john.smith@example.com" />
            </label>
        </div>
        <div>
            <label>
                Password:
                <input type="password" name="password" />
            </label>
        </div>
        <div class="btn-container">
            <button type="submit" class="btn">Register</button>
        </div>
    </form>
</div>
