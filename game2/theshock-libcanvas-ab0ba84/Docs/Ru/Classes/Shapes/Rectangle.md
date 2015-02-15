LibCanvas.Shapes.Rectangle
==========================

`LibCanvas.Shapes.Rectangle` - базовая фигура в LibCanvas, которая используется в том числе в отрисовке холста (например в `ctx.drawImage`)

#### Global

После вызова LibCanvas.extract() можно использовать короткий алиас "Rectangle"

## Создание экземпляра LibCanvas.Shapes.Rectangle
	// координаты первой точки и размеры
	var rect = new LibCanvas.Shapes.Rectangle( xFromCoord, yFromCoord, width, height );

	// две точки LibCanvas.Point - откуда и куда
	var rect = new LibCanvas.Shapes.Rectangle( fromPoint, toPoint );

	// объект параметров (должно быть два любых аргумента из трех, например, from и size)
	var rect = new LibCanvas.Shapes.Rectangle({
		from : fromPoint,
		to   : toPoint,
		size : size
	});

Вы можете экспериментировать с видом аргументов, LibCanvas очень гибкий и будет подстраиватся под то, что вы пишете. Но будьте осторожны с этим:
	var rect = new LibCanvas.Shapes.Rectangle({
		from : [5, 10],
		size : {
			width  : 15,
			height : 20
		}
	});
	var rect = new LibCanvas.Shapes.Rectangle({
		to : new LibCanvas.Point(20, 30),
		size : [15, 20]
	});

Не забывайте, что точки передаются по ссылке, потому если вы объявили rectangle через две точки то при изменении точки внутри прямоугольника будут менятся и оригинальные точки. С этим эффектом можно делать множество полезных трюков

	var rect = new LibCanvas.Shapes.Rectangle( fromPoint, toPoint );
	rect.from.x = 100;
	alert(fromPoint.x); // 100

Если необходимо, такого поведения можно избежать, передавая клоны точек

	var rect = new LibCanvas.Shapes.Rectangle( fromPoint.clone(), toPoint.clone() );

Или клонируя ректангл (предыдущее - предпочтительнее):

	var rect = new LibCanvas.Shapes.Rectangle( fromPoint, toPoint ).clone();

## Свойства

### width (set/get)
Получить ширину прямоугольника или изменить (сдвинув точку to по координате x)

### height (set/get)
Получить ширину прямоугольника или изменить (сдвинув точку to по координате y)

### bottomLeft (get)
Создает новую точку с координатами, которые соотвутствуют левому нижнему углу прямоугольника

### topRight (get)
Создает новую точку с координатами, которые соотвутствуют правому верхнему углу прямоугольника

### center (get)
Создает новую точку с координатами, которые соотвутствуют центру прямоугольника

### size (set/get)
Получить/установить высоту и ширину прямоугольника в формате {width, height}

## Метод hasPoint

	bool hasPoint(LibCanvas.Point point, int padding);

Возвращает true если точка находится внутри или на границе прямоугольника

#### аргумент `padding`
	Учитывает отступы от границы

#### Пример
	var rect = new LibCanvas.Shapes.Rectangle({
		from : [ 4,  4],
		to   : [10, 10]
	});
	rect.hasPoint( [6, 6] ); // true
	rect.hasPoint( [2, 2] ); // false
	rect.hasPoint( [3, 3], 2 ); // false

## Метод align

	LibCanvas.Shapes.Rectangle align(LibCanvas.Shapes.Rectangle rect, string sides);

Выравнивает прямоугольник относительно другого прямоугольника. sides может содержать top/middle/bottom или left/center/right

	// центрируем прямоугольник относительно холста
	rectangle.align( context.rectangle, 'center middle' ), 'red'

## Метод move

	LibCanvas.Shapes.Rectangle move(LibCanvas.Point distance, bool reverse);

Вызывает метод move у обоих точек

#### События
	rect.addEvent('move', function (distance) {
		alert('Прямоугольник передвинулся на '
			+ distance.x + ' по оси X и на '
			+ distance.y + ' по оси Y'
		);
	});

#### Пример
	var rect = new LibCanvas.Shapes.Rectangle({
		from : [4, 4],
		to   : [8, 8]
	});
	rect.move({ x : 2, y : 3 });
	// rect.from == Point( 6,  7)
	// rect.to   == Point(10, 11)

#### Возвращает `this`

## Метод draw

	LibCanvas.Shapes.Rectangle draw(LibCanvas.Context2D ctx, String type);

Отрисовывает прямоугольник в контекст, используя текущие настройки

#### аргумент `type`
	Способ отрисовки. Может принимать значения `fill`, `stroke`, `clear`

#### Пример
	var rect = new LibCanvas.Shapes.Rectangle(10, 10, 5, 5);
	var ctx  = canvasElem
		.getContext('2d-libcanvas')
		.set({
			'fillStyle': 'red',
			'strokeStyle': 'black'
		});
	// Зальем красным прямоугольник в контексте
	rect.draw(ctx, 'fill');
	// Обведем черным прямоугольник в контексте
	rect.draw(ctx, 'stroke');

Но такой способ рекомендуется использовать только если по какой либо причине не доступен следующий:

	var ctx  = canvasElem
		.getContext('2d-libcanvas')
		.fill  (rect, 'red')
		.stroke(rect, 'black');


## Метод moveTo

	LibCanvas.Shapes.Rectangle moveTo(LibCanvas.Shapes.Rectangle rect)

Перемещает текущий прямоугольник так, чтобы он стал равен прямоугольнику, переданному аргументом


	var Rectangle = LibCanvas.Shapes.Rectangle;
	var rectFrom = new Rectangle({
		from : [10, 10],
		to   : [20, 20]
	});
	var rectTo   = new Rectangle({
		from : [15, 15],
		to   : [25, 25]
	});
	rectFrom.moveTo(rectTo);

	rectFrom.from; // Point(15, 15);
	rectFrom.to  ; // Point(25, 25);

#### Возвращает `this`

## Метод processPath

	LibCanvas.Context2D processPath(LibCanvas.Context2D ctx, bool noWrap = false)

Проходит путь с помощью `ctx.moveTo`, `ctx.lineTo` начиная с точки `from` по часовой стрелке

#### аргумент `noWrap`
если указан в false(по умолчанию), то обрамляет с помощью beginPath, endPath

#### Пример
	LibCanvas.Shapes.Rectangle({
		from : [4, 4],
		to   : [8, 8]
	}).processPath(ctx);

	// равносильно c:
	ctx.beginPath()
	   .moveTo(4, 4) // rect.from
	   .lineTo(4, 8)
	   .lineTo(8, 8) // rect.to
	   .lineTo(8, 4)
	   .lineTo(4, 4) // rect.from
	   .closePath();
</code></pre></div>

## Метод getRandomPoint

	LibCanvas.Point getRandomPoint(int margin = 0);

Возвращает случайную точку, находящуюся внутри прямоугольника

#### аргумент `margin`
если указан, то точка будет возвращена с учетом отступов

#### Примеры
	var rect = LibCanvas.Shapes.Rectangle({
		from : [10, 10],
		to   : [90, 90]
	});

	// Вернет случайную точку, у которой координаты будут между 10 и 90
	rect.getRandomPoint();    // например Point(53, 87)

	// Вернет случайную точку, у которой координаты будут между 40(10+30) и 60(90-30)
	rect.getRandomPoint( 30); // например Point(49, 43)

	// Вернет случайную точку, у которой координаты будут между -20(10-30) и 120(90+30)
	rect.getRandomPoint(-30); // например Point(96, -5)
</code></pre></div>

## Метод equals

	bool equals(LibCanvas.Shapes.Rectangle rect, int accuracy)

Сравнивает точки многоугольников методом LibCanvas.Point.equals

	var foo = new LibCanvas.Shapes.Rectangle(15, 20, 10, 5);
	var bar = new LibCanvas.Shapes.Rectangle(15, 20, 10, 5);

	trace(bar == foo);      // false
	trace(bar.equals(foo)); // true

## Метод clone
	LibCanvas.Shapes.Rectangle clone()

Возвращает прямоугольник с такими же координатами

	var rect  = new LibCanvas.Shapes.Rectangle(15, 20, 10, 5);
	var clone = rect.clone();

	trace(rect == clone);      // false
	trace(rect.equals(clone)); // true
