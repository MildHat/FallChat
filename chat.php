<?php 
    session_start();
    if(!isset($_SESSION["session_username"])) {
      header("Location: index.php");
    }
?>
<?php include("includes/header.php"); ?>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
  //Загружаем библиотеку JQuery
  google.load("jquery", "1.3.2");
  google.load("jqueryui", "1.7.2");
  
  //Функция отправки сообщения
  function send()
  {
    //Считываем сообщение из поля ввода с id mess_to_add
    var mess=$("#mess_to_send").val();
    // Отсылаем паметры
       $.ajax({
                type: "POST",
                url: "add_mess.php",
                data:"mess="+mess,
                // Выводим то что вернул PHP
                success: function(html)
        {
          //Если все успешно, загружаем сообщения
          load_messes();
          //Очищаем форму ввода сообщения
          $("#mess_to_send").val('');
                }
        });
  }
  
  //Функция загрузки сообщений
  function load_messes()
  {
    $.ajax({
                type: "POST",
                url:  "load_messes.php",
                data: "req=ok",
                // Выводим то что вернул PHP
                success: function(html)
        {
          //Очищаем форму ввода
          $("#messages").empty();
          //Выводим что вернул нам php
          $("#messages").append(html);
          //Прокручиваем блок вниз(если сообщений много)
          $("#messages").scrollTop(90000);
                }
        });
  }
</script>
    <ul class="menu">
      <li><a class="active" href="">Chat</a></li>
      <li id="hi"><a>Welcome, <span><?php echo $_SESSION['session_username'];?>! </span></a>
        <ul class="submenu">
          <li><a href="#">choto</a></li>
          <li><a href="options.php">Options</a></li>
          <li><a href="logout.php">Sign out</a></li>
        </ul>
      </li>
    </ul>
    <div class="col-xs-3"></div>

    <div class="col-xs-6">
      <div class="inp">
        <p id="messages"> 
        </p>
        <form action="javascript:send();">
        <input id="mess_to_send" type="text" size="63" />
        <input id="enterM" name="submitmsg" type="submit" value="Send" />
        </form>
      </div>
      </div>

      <script>
//При загрузке страницы подгружаем сообщения
load_messes();
//Ставим цикл на каждые три секунды
setInterval(load_messes,3000);
</script>
  </body>
</html>
