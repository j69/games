<html>
	<head>
		<title>Игра Daldos</title>
		<link rel="stylesheet" href="css/style.css">
		<script src="http://code.jquery.com/jquery-1.9.0.min.js"></script>
		<script src="js/fabric.js"></script>
		<script>
			$(function(){
				//var ctx = $('canvas')[0].getContext('2d');
				var canvas = new fabric.StaticCanvas('c');
/*				canvas.add(
				  new fabric.Rect({ top: 100, left: 100, width: 50, height: 50, fill: '#f55' }),
				  new fabric.Circle({ top: 140, left: 230, radius: 75, fill: 'green' }),
				  new fabric.Triangle({ top: 300, left: 210, width: 100, height: 100, fill: 'blue' })
				);*/

				function makeLine(coords) {
				  return new fabric.Line(coords, {
				    fill: 'orange',
				    strokeWidth: 5,
				    selectable: false
				  });
				}

				var line  = makeLine([ 50, 120, 520, 120 ]),
				    line2 = makeLine([ 520, 120, 600, 240 ]),
				    line3 = makeLine([ 600, 240, 520, 360]),
				    line4 = makeLine([ 520, 360, 50, 360]),
				    line5 = makeLine([ 50, 360, 50, 120]);

				canvas.add(line, line2, line3, line4, line5);
				line.fill('black');
				var polygon = new fabric.Polygon({
  left: 50,
  top: 120,
  fill: 'purple',
  selectable: false
});
canvas.add(polygon);


				/*******************
					draw board:
				*******************/
				/*ctx.beginPath();
				ctx.lineTo(50, 120);
				ctx.lineTo(520, 120);
				ctx.lineTo(600, 240);
				ctx.lineTo(520, 360);
				ctx.lineTo(50, 360);
				ctx.closePath();
				ctx.fillStyle = "#fdeaa8";
				ctx.strokeStyle = "orange";
				ctx.fill();
				ctx.stroke();*/



				// Карта уровня двумерным массивом
				/*cellSize = 32;
				example.width = 10*cellSize;
				example.height = 3*cellSize;*/

				// Первая и вторая координата задаёт клетку в исходном изображении
				var map = [
					[{x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}],  // 1ый ряд карты
					[{x:1, y: 4}, {x:1, y: 1}, {x:2, y: 1}, {x:3, y: 1}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}],  // 2ый ряд карты
					[{x:1, y: 4}, {x:1, y: 2}, {x:2, y: 2}, {x:3, y: 2}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}]  // 3ый ряд карты
				  ];

				/*//Самой элементарной фигурой которую можно рисовать является прямоугольник. Предусмотрено три функции для отрисовки прямоугольников:
				strokeRect(x, y, ширина, высота) // Рисует прямоугольник
				fillRect(x, y, ширина, высота)   // Рисует закрашенный прямоугольник
				clearRect(x, y, ширина, высота)  // Очищает область на холсте размер с прямоугольник заданного размера

				//рисуем Щахматную доску:
				example.width  = 640;
				example.height = 480;
				ctx.strokeRect(15, 15, 266, 266);
				ctx.strokeRect(18, 18, 260, 260);
				ctx.fillRect(20, 20, 256, 256);
				for (i=0; i<8; i+=2)
				 for (j=0; j<8; j+=2) {
						ctx.clearRect(20+i*32, 20+j*32, 32, 32);
						ctx.clearRect(20+(i+1)*32, 20+(j+1)*32, 32, 32);
					}*/


			   /*Рисование фигур составленных из линий выполняется последовательно в несколько шагов:
			   beginPath() - «начать» серию действий описывающих отрисовку фигуры. Каждый новый вызов этого метода сбрасывает все действия предыдущего и начинает «рисовать» занова.
			   closePath() - (не обязательное) пытается завершить рисование проведя линию от текущей позиции к позиции с которой начали рисовать.
			   stroke() - обводит фигуру линиями
			   fill() - заливает фигуру сплошным цветом.

				Те кто когда-то на школьных 486х в былые годы рисовал в бейсике домик, забор и деревце по задумке учителя тот сразу поймёт часть ниже. Итак, существуют такие методы как,

				moveTo(x, y) - перемещает "курсор" в позицию x, y и делает её текущей
				lineTo(x, y) - ведёт линию из текущей позиции в указанную, и делает в последствии указанную текущей
				arc(x, y, radius, startAngle, endAngle, anticlockwise) - рисование дуги, где x и y центр окружности, далее начальный и конечный угол, последний параметр указывает направление
				*/

				/*рисует корону:
				example.height = 480;
				example.width = 640;
				ctx.beginPath();
				ctx.arc(80, 100, 56, 3/4*Math.PI, 1/4*Math.PI, true);
				ctx.fill(); // *14
				ctx.moveTo(40, 140);
				ctx.lineTo(20, 40);
				ctx.lineTo(60, 100);
				ctx.lineTo(80, 20);
				ctx.lineTo(100, 100);
				ctx.lineTo(140, 40);
				ctx.lineTo(120, 140);
				ctx.stroke(); // *22
				*/

			   /*
			   Нам доступно две функции, для построения кубической кривой Бизье и квадратичной, соотвестствено:

			   quadraticCurveTo(Px, Py, x, y)
			   bezierCurveTo(P1x, P1y, P2x, P2y, x, y)

			   x и y это точки в которые необходимо перейти, а координаты P(Px, Py) в квадратичной кривой это дополнительные точки которые используются для построения кривой. В кубическо кривой соответственно две дополнительные точки.
				*/

			   /*рисуем крыло
				example.height = 480;
				example.width = 640;
				ctx.beginPath();
				ctx.moveTo(10, 15);
				ctx.bezierCurveTo(75, 55, 175, 20, 250, 15);
				ctx.moveTo(10, 15);
				ctx.quadraticCurveTo(100, 100, 250, 15);
				ctx.stroke();

			*/
			   /* Что бы наше изображение было не только двух цветов, а любого цвета предусмотрено, два свойства
					fillStyle = color   // определяет цвет заливки
					strokeStyle = color // цвет линий цвет задается точно так же как и css, на примере все четыре способа задания цвета

					// все четыре строки задают оранжевый цвет заливки:
					ctx.fillStyle = "orange";
					ctx.fillStyle = "#FFA500";
					ctx.fillStyle = "rgb(255,165,0)";
					ctx.fillStyle = "rgba(255,165,0,1)"
				*/

			   /*
			   Добавление изображения условно можно разделить на два шага: создание JavaScript объекта Image, а второй и заключительный шаг это отрисовка изображения на холсте при помощи функции drawImage. Рассмотрим оба шага подробнее.

				Создание нового графического объекта:
				var img = new Image();  // Создание нового объекта ихображения
				img.src = 'image.png';  // Путь к изображению которое необходимо нанести на холст

				Кстати в качестве источника изображения, можно указать вот такую строку в которой изображение и описанно:
				imgSrc = 'data:image/gif;base64,R0lGODlhDAAMAOYAANPe5Pz//4KkutDb4szY3/b+/5u5z/3//3KWrfn//8rk8naasYGku
				*/
			   /*
				drawImage(image, x, y) - x и y это координаты левого верхнего угла изображения, а первый параметр это то изображение которое должно быть нарисовано

				drawImage(image, x, y, width, height)  // можно растянуть img - width, height меняют ширину и высоту изображения

				drawImage(image, sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight) - нарисовтать кусочек картинки
					sx, sy, sWidth, sHeight это параметры фрагмента на изображение-источнике,
					dx, dy, dWidth, dHeight это координаты отрисовки фрагмента на холсте


				загрузка изображения происходит сразу после присвоения объекту источника изображения, и если оно не загрузится полностью к моменту вызова функции отрисовки, то оно попросту не будет нарисовано на холсте. Для избежания этой ситуации используется такая конструкция:

				var img = new Image();  // Новый объект
				img.onload = function(){  // Событие которое будет исполнено когда изображение будет полностью загружено
				}
				img.src = 'myImage.png';  // Путь к изображению
				*/
	/*             var pic = new Image();  // "Создаём" изображение
				pic.src = 'http://habrahabr.ru/i/nocopypast.png';  // Источник изображения
				pic.onload = function() {  //ждём загрузки
				  //ctx.drawImage(pic, 0, 0);  // Рисуем изображение от точки с координатами 0, 0
				  //ctx.drawImage(pic, 0, 0, 300, 150);//Растягивает img
				  ctx.drawImage(pic, 25, 42, 85, 55, 0, 0, 170, 110);//Только кусочек рисует
				}*/


				/*******************
					Рисуем домик:
				********************
				cellSize = 32;// Размер одной ячейки на карте
				example.width = 8*cellSize;// Размер канваса равный 8х8 клеток
				example.height = 8*cellSize;
				// Карта уровня двумерным массивом
				// Первая и вторая координата задаёт клетку в исходном изображении
				var map =
				  [
					[{x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}],  // 1ый ряд карты
					[{x:1, y: 4}, {x:1, y: 1}, {x:2, y: 1}, {x:3, y: 1}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}],  // 2ый ряд карты
					[{x:1, y: 4}, {x:1, y: 2}, {x:2, y: 2}, {x:3, y: 2}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}],  // 3ый ряд карты
					[{x:1, y: 4}, {x:3, y: 4}, {x:2, y: 3}, {x:3, y: 4}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 4}, {x:1, y: 4}],  // 4ый ряд карты
					[{x:1, y: 4}, {x:3, y: 4}, {x:2, y: 4}, {x:3, y: 4}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 4}, {x:1, y: 4}],  // 5ый ряд карты
					[{x:1, y: 4}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 4}, {x:1, y: 4}],  // 6ый ряд карты
					[{x:1, y: 4}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 4}, {x:1, y: 4}],  // 7ый ряд карты
					[{x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}]   // 8ый ряд карты
				  ];

				var pic = new Image();  // "Создаём" изображение
				pic.src = 'http://dl.dropbox.com/u/8307275/p/set.png';  // Источникнашего тайлсэта
				pic.onload = function() {  // Событие onLoad, ждём момента пока загрузится изображение
				  for (var j=0; j<8; j++)
					for (var i=0; i<8; i++)
					  // перебираем все значения массива 'карта' и в зависимости от координат вырисовываем нужный нам фрагмент
					  ctx.drawImage(pic, (map[i][j].x-1)*cellSize, (map[i][j].y-1)*cellSize, 32, 32, j*cellSize, i*cellSize, 32, 32);  // Рисуем изображение от точки с координатами 0, 0
				}*/
				/*$('.dot').mouseup( function(){
					//координаты текущего положения объекта
				});*/
			});
		</script>
	</head>
	<body>
		<!-- <p>Еще есть <a href="http://www.benjoffe.com/code/demos/canvascape"> бродилка</a></p>
		<br/> -->
		<div id="wrapper">
			<div id="wrapper-text">
				 Daldosa!
			</div>
			<canvas height='480' width='640' id='c'>Обновите браузер</canvas>
			<div class="ship">
			</div>
			<span class="dot">&#9829;</span>
		</div>
	</body>
</html>