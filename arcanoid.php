<html>
	<head>
		<script src="http://code.jquery.com/jquery-1.8.2.min.js">//91.2 KB</script>
		<style type="text/css">
			body{
				margin: 0 auto;
				display: block;
			}
			#playing-area /*Игровая площадка*/
    {
     position : absolute;
     left : 10%; top : 10%; width : 80%; height : 80%;
     background-color : rgba(200,200,200,0.5);
     box-shadow: 0px 0px 20px #777;
     z-index:0;
    }

   #info /*Информационная панель*/
    {
     position : absolute;
     left : 0%; top : 0%; width : 10%; height : 100%;
     border : none;
     font-family : "trebuchet ms", Verdana, Tahoma, Arial, Sans-Serif;
     font-size : 18px;
     color : Dodgerblue;
    }

   #platform /*Платформа*/
    {
     position : absolute;
     left : 50%; top : 100%; width : 150px; height : 20px;
     margin-left : -75px;
     margin-top : -20px;
     border : none;
     background-color : #777;
     box-shadow: inset 0px 0px 20px #fff;
     z-index:1;
    }

   #platform p /*Параграф внутри платформы*/
    {
      margin : 0;
      font-family : "trebuchet ms", Verdana, Tahoma, Arial, Sans-Serif;
      font-size : 14px;
      font-weight : bold;
      color : #777;
      text-align : center;
      text-shadow: #fff 1px 1px 2px;
    }

   #ball,.ball /*Мяч (в игре и для обозначения количества попыток)*/
    {
     position : absolute;
     width : 20px; height : 20px;
     background-color : #555;
     border-radius: 10px;
     box-shadow: inset 5px 0px 5px #fff;
     z-index:1;
    }

   .brick /*Кирпич*/
    {
     position : absolute;
     border : none;
     background-color : #bbb;
     border-radius: 5px;
     box-shadow: inset 0px 0px 10px #333;
     z-index:1;
    }

   .brick p /*Параграф внутри кирпича*/
    {
      margin : 0;
      font-family : "trebuchet ms", Verdana, Tahoma, Arial, Sans-Serif;
      font-size : 14px;
      font-weight : bold;
      color : #777;
      text-align : center;
      text-shadow: #fff 1px 1px 2px;
    }

    h1 {/*Стиль для вывода заголовка*/
      font-family : "trebuchet ms", Verdana, Tahoma, Arial, Sans-Serif;
      font-size : 20px;
      color : #777;
      text-align : center;
    }

   .copyright {/*Блок для вывода информации об авторском праве*/
      position : absolute;
      left : 50%; top : 100%; width : 700px; height : 40px;
      margin-left : -350px;
      margin-top : -40px;
    }

   .copyright p {/*Стиль для вывода информации об авторском праве*/
      font-family : "trebuchet ms", Verdana, Tahoma, Arial, Sans-Serif;
      font-size : 11px;
      color : #111;
      position : relative;
      text-align : center;
    }
		</style>
		<script>
			/*$(function(){
				//Canvas
				//var ctx = $('canvas')[0].getContext('2d');

			});*/
/*------------------------------------Объектный состав игры 'Арканоид'----------------------------------------------*/
   //JavaScript Объект 'игровая площадка' (playing area)
   function pa()
   {
     //Получаем элемент по id средствами jQuery
     this.element = $("#playing-area");

     //Выравниваем размер игровой площадки в соответствии с количеством кирпичей
     this.element.width(Math.round(this.element.width() / _bricks_line) * _bricks_line);
     this.element.height(Math.round(this.element.height() / _bricks_lines_max) * _bricks_lines_max);

     //Сохраняем параметры смещения и габариты
     this.offset = this.element.offset();
     this.width = this.element.width();
     this.height = this.element.height();

     //Вычисляем размеры объекта 'кирпич'
     this.brick_width = Math.round(this.width / _bricks_line);
     this.brick_height = Math.round(this.height / _bricks_lines_max);

     //Создаем экземпляры платформы-ракетки и шарика
     this.platform = new platform(this);
     this.ball = new ball(this);

     //Методы объекта:
     //Создаем объекты 'кирпич' средствами jQuery
     this.initBricks = function()
      {
       for (var i = 0; i < _bricks_lines; i++)
            for (var j = 0; j < _bricks_line; j++)
                 //Метод prepend() позволяет добавить HTML в конец содержимого игровой площадки
                 this.element.prepend("<div id='brick_"+i+"_"+j+"' class='brick' style='left:"+(j * this.brick_width + 1)+"px; top:"+(i * this.brick_height + 1)+"; width:"+(this.brick_width - 2)+"px; height: "+(this.brick_height - 2)+"px'><p>"
				      + (Math.round(Math.random() * (_bricks_lines - i)) + (_bricks_lines - i)) + "</p></div>");
      }

     //Функция подготовки площадки arcanoid к началу игры
     this.prepare = function()
      {
       this.try_count = _try_count_max;
       this.score = 0;

       //Если остались кирпичи с прошлого сеанса игры, то все их удаляем средствами запроса jQuery
       $('.brick').remove();

       //Создаем кирпичи по новой
       this.initBricks();
       //Устанавливаем шарик на платформе
       this.ball.reset();
       //Выводим информацию о количестве попыток и очках
       this.showInfo();
      }

     //Вывод информации о количестве попыток и очках
     this.showInfo =  function()
      {
       var _try_count_balls = "";
       for (var i = 0; i < this.try_count - 1; i++)
            _try_count_balls = _try_count_balls + "<div class='ball' style='position: relative; float: left;'></div>";

       $('#info').html("$" + this.score + "<br/>" + _try_count_balls);
      }
   }

   //JavaScript Объект 'платформа-ракетка'
   function platform(pa)
   {
     //Определяем и инициализируем свойства объекта
     this.pa = pa;
     this.element = $("#platform"); //Получаем элемент по id средствами jQuery
     this.width = this.element.width();
     this.height = this.element.height();
     this.interval = 0;
     this.dx = 0;
     this.last_x = 0;

     //Методы объекта:
     //Вычисление вектора перемещения платформы (используется для эффекта 'подрезания')
     this.evaluate_dx = function()
     {
       if (this.last_x > 0)
           this.dx = this.element.offset().left - this.last_x;

       this.last_x = this.element.offset().left;
     }

     //Перемещение
     this.move = function(x)
     {
       var _left = x - this.width / 2;
       var _left_min = this.pa.offset.left;
       var _left_max = this.pa.offset.left + this.pa.width - this.width;

       if (_left < _left_min)
           _left = _left_min;

       if (_left > _left_max)
           _left = _left_max;

        this.element.offset({left:_left});

       //Если шарик в состоянии покоя, то выравниваем его по центру платформы
       if (this.pa.ball.ready)
           this.pa.ball.setUp();
     }
   }

   //JavaScript Объект 'шарик'
   function ball(pa)
   {
     //Определяем и инициализируем свойства объекта
     this.pa = pa;
     this.element = $("#ball"); //Получаем элемент по id средствами jQuery
     this.width = this.element.width();
     this.height = this.element.height();
     this.interval = 0;
     this.ready = true;
     this.dx = 0;
     this.dy = 0;

     //Методы объекта:
     //Функция отбивания шарика
     this.kick = function()
     {
      if (this.dy > 0)
          this.dy = -this.dy;
      else
         {/*Запуск с платформы*/
          if (this.pa.platform.dx == 0)/*Если платформа в покое, то смещение по горизонтали рассчитывается случайным образом*/
              this.dx = 2 - Math.round(Math.random() * 5);

          this.dy = -_ball_dy;
         }

      this.dx = this.dx + Math.round(this.pa.platform.dx / 5);

      //Ограничение по скорости по горизонтали
      if (Math.abs(this.dx) > _ball_dx_max)
          if (this.dx > 0)
              this.dx = _ball_dx_max;
          else
              this.dx = -_ball_dx_max;
      }

      //Установка шарика по центру платформы
      this.setUp = function()
      {
       this.element.offset({left:this.pa.platform.element.offset().left + this.pa.platform.width / 2 - this.width / 2, top:this.pa.platform.element.offset().top - this.height});
      }

      //Обработка 'падения' шарика - отключение обработчика, установка на платформе и обнуление вектора смещения
      this.reset = function()
      {
        if (this.interval)
            clearInterval(this.interval);

        this.setUp();

        this.dx = 0;
        this.dy = 0;
        this.ready = true;
      }

      //Единичное перемещение шарика
      this.move = function()
      {
       var _ball_offset = this.element.offset();
       var _platform_offset = this.pa.platform.element.offset();

       if ((_ball_offset.left < this.pa.offset.left && this.dx < 0) || (_ball_offset.left + this.width > this.pa.offset.left + this.pa.width && this.dx > 0))
           this.dx = -this.dx //Удар о вертикальные стенки
       else if (_ball_offset.top < this.pa.offset.top && this.dy < 0)
                this.dy = -this.dy //Удар о верхнюю стенку
            else if (_ball_offset.top > _platform_offset.top - this.height  && this.dy > 0) //Падение ниже платформы
                     if (_ball_offset.left > _platform_offset.left - this.width && _ball_offset.left < _platform_offset.left + this.pa.platform.width)
                        {//Отбивание платформой
                         this.kick();
                         this.pa.platform.element.fadeTo(200, 0.5, function(){$("#platform").fadeTo(200, 1)});
                        }
                     else //Обработка падения шарика
                         {
                          this.pa.try_count--; //уменьшение количества попыток

                          if (this.pa.try_count > 0)
                             {//Старт с новой попыткой
                              this.pa.showInfo();
                              this.reset();
                             }
                          else //Окончание игры
                             gameOver();

                          return;
                         }

       //Обработка попадания по кирпичам:
       //Вычисляем предполагаемые координаты в следующий момент
       var _ball_next_x = _ball_offset.left + this.dx;
       var _ball_next_y = _ball_offset.top + this.dy;
       //Вычисляем координаты кирпича в системе координат 'место-ряд'
       var _xindex = Math.floor((_ball_next_x - this.pa.offset.left) / this.pa.brick_width);
       var _yindex = Math.floor((_ball_next_y - this.pa.offset.top) / this.pa.brick_height);

       //Ищем элемент 'кирпич' средствами запроса jQuery по id
       var _bricks = $("#brick_"+_yindex+"_"+_xindex);
       if (_bricks.size() > 0)
           {
            var _brick = _bricks[0];
            //Если кирпич не в состоянии 'удаления', то инициализируем его удаление и рассчитываем отскок
            if (typeof _brick.broken == "undefined")
               {
                //Получаем параметры области блочного элемента
                var _rect = _brick.getBoundingClientRect();

                //Определяем направление отскока
                if (_ball_offset.left > _rect.left - this.width && _ball_offset.top < _rect.left + _rect.width)
                   this.dy = -this.dy;
                else
                   this.dx = -this.dx;

                //Помечаем кирпич как 'удаляемый'
                _brick.broken = true;
                //Инициализируем удаление элемента 'кирпич' после его исчезновения средствами jQuery
                $("#"+_brick.id).hide(200, function(){$("#"+this.id).remove()});

                //Кроссбраузерно получаем текст с количеством очков за кирпич
                var _brickInnerText;
                if (_brick.innerText)
                   _brickInnerText = _brick.innerText
                else
                   _brickInnerText = _brick.textContent //для Firefox

                //Определяем очки за кирпич и суммируем результат
                var _brickScore = parseInt(_brickInnerText);

                if (!isNaN(_brickScore))
                    this.pa.score = this.pa.score + _brickScore;

                //Обновляем очки
                this.pa.showInfo();
                return;
              }
           }

       //Перемещение шарика
       this.element.offset({left:_ball_offset.left + this.dx, top:_ball_offset.top + this.dy});
      }
   }

/*------------------------------------Основной код--------------------------------------------------*/
//Основные настройки игры
   const _bricks_line = 20;      //Количество кирпичей в ряду (определяет ширину кирпича)
   const _bricks_lines = 5;      //Количество рядов кирпичей
   const _bricks_lines_max = 20; //Максимальное количество рядов кирпичей (определяет высоту кирпича)
   const _ball_dy = 5;           //Скорость шарика по вертикали
   const _ball_dx_max = 5;       //Максимальная скорость шарика по горизонтали (ограничение результата 'подрезки' шарика платформой-ракеткой)
   const _try_count_max = 5;     //Количество попыток (шариков)

//Экземпляр игровой площадки
   var _pa;

//Глобальные функции
//Рестарт игры
   function restart()
   {
     if (_pa.platform.interval)
         clearInterval(_pa.platform.interval);

     //Подготовка площадки
     _pa.prepare();
     //Вычисление вектора перемещения платформы каждые 10 мс.
     _pa.platform.interval = window.setInterval(function() {_pa.platform.evaluate_dx()}, 10);
   }

//Запуск шарика
   function launchBall()
   {
     //запуск шарика
     _pa.ball.kick();
     //Перемещение шарика каждые 10 мс.
     _pa.ball.interval = window.setInterval(function() {_pa.ball.move()}, 10);
     //шарик в состоянии 'полета'
     _pa.ball.ready = false;
   }

//Конец игры
   function gameOver()
   {
     alert("Игра окончена. Ваши очки: " + _pa.score);
     restart();
   }

//Инициализация структур данных 'Арканоид' после загрузки страницы средствами jQuery
   $(document).ready(function()
   {
     //Создаем игровую площадку
     _pa = new pa();

     //Инициализируем игру
     restart();

     //Привязываем обработку события mousemove средствами jQuery
     $(document).mousemove(function(event)
                  {
                   //Кроссбраузерное получение события
                   event = event || window.event;

                   //Кроссбраузерное получение координат мыши и перемещение платформы
                   _pa.platform.move(event.pageX || event.x);
                  })

     //Привязываем обработку события mousedown средствами jQuery
     $(document).mousedown(function(event)
                  {
                    //Если шарик в состоянии 'полета', то ничего не делаем
                    if (!_pa.ball.ready)
                        return;

                    //Запуск шарика
                    launchBall();
                  })
   })
		</script>
	</head>
	<body>
		<!--<canvas height='320' width='640' id='canvas'>Refresh browser</canvas>-->
		  <div id='info'></div>
		  <div id='playing-area'>
		   <div id='ball'></div>
		   <div id='platform'><p>codingcraft.ru</p></div>
		  </div>
	</body>
</html>