<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    *{
        font-family: Arial, Helvetica, sans-serif;
    }
    body{
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        height: 100vh;
        align-items: center;
        background: rgb(0, 0, 0, 0.8);
    }
    .content{
        padding: 10px;
        background-color: #752BDF;
        height: 450px;
        width: 500px;
    }
    .content h1{
        text-align: center;
        font-size: 2em;
        color: white;
    }
    form{
        display: flex;
        justify-content: center;
        flex-direction: column;
        margin: 25px;
    }
    form input{
        border-radius: 30px;
        font-size: 1em;
        font-weight: bold;
        border: none;
        padding: 12px;
    }
    button{
        border-radius: 30px;
        border: none;
        padding: 12px;
        font-size: 1em;
        font-weight: bold;
    }
    button:hover{
        box-shadow: 3px 3px 3px black;
        transition: 0.3s;
    }
    .error{
        background: #F2DEDE;
        color: #A94442;
        padding: 10px;
        width: 95%;
        border-radius: 5px;
        margin: 20px auto;
    }
</style>
<body>
    <div class="container">
        <div class="content">
            <h1>Admin</h1>
            <h1>Mountain View Community Hospital</h1>
            <form action="login.php" method="POST">
                <?php if(isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error'];?></p>
                <?php } ?>
                <input type="text" name="uname" placeholder="Enter your Name"><br>

                <input type="password" name="password" placeholder="Enter your Password"><br>
                <button type="submit">Submit</button>

            </form>
        </div>
    </div>
</body>
</html>