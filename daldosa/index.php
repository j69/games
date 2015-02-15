<html>
	<head>
		<title>���� Daldos</title>
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



				// ����� ������ ��������� ��������
				/*cellSize = 32;
				example.width = 10*cellSize;
				example.height = 3*cellSize;*/

				// ������ � ������ ���������� ����� ������ � �������� �����������
				var map = [
					[{x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}],  // 1�� ��� �����
					[{x:1, y: 4}, {x:1, y: 1}, {x:2, y: 1}, {x:3, y: 1}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}],  // 2�� ��� �����
					[{x:1, y: 4}, {x:1, y: 2}, {x:2, y: 2}, {x:3, y: 2}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}]  // 3�� ��� �����
				  ];

				/*//����� ������������ ������� ������� ����� �������� �������� �������������. ������������� ��� ������� ��� ��������� ���������������:
				strokeRect(x, y, ������, ������) // ������ �������������
				fillRect(x, y, ������, ������)   // ������ ����������� �������������
				clearRect(x, y, ������, ������)  // ������� ������� �� ������ ������ � ������������� ��������� �������

				//������ ��������� �����:
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


			   /*��������� ����� ������������ �� ����� ����������� ��������������� � ��������� �����:
			   beginPath() - �������� ����� �������� ����������� ��������� ������. ������ ����� ����� ����� ������ ���������� ��� �������� ����������� � �������� ���������� ������.
			   closePath() - (�� ������������) �������� ��������� ��������� ������� ����� �� ������� ������� � ������� � ������� ������ ��������.
			   stroke() - ������� ������ �������
			   fill() - �������� ������ �������� ������.

				�� ��� �����-�� �� �������� 486� � ����� ���� ������� � ������� �����, ����� � ������� �� ������� ������� ��� ����� ����� ����� ����. ����, ���������� ����� ������ ���,

				moveTo(x, y) - ���������� "������" � ������� x, y � ������ � �������
				lineTo(x, y) - ���� ����� �� ������� ������� � ���������, � ������ � ����������� ��������� �������
				arc(x, y, radius, startAngle, endAngle, anticlockwise) - ��������� ����, ��� x � y ����� ����������, ����� ��������� � �������� ����, ��������� �������� ��������� �����������
				*/

				/*������ ������:
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
			   ��� �������� ��� �������, ��� ���������� ���������� ������ ����� � ������������, ��������������:

			   quadraticCurveTo(Px, Py, x, y)
			   bezierCurveTo(P1x, P1y, P2x, P2y, x, y)

			   x � y ��� ����� � ������� ���������� �������, � ���������� P(Px, Py) � ������������ ������ ��� �������������� ����� ������� ������������ ��� ���������� ������. � ��������� ������ �������������� ��� �������������� �����.
				*/

			   /*������ �����
				example.height = 480;
				example.width = 640;
				ctx.beginPath();
				ctx.moveTo(10, 15);
				ctx.bezierCurveTo(75, 55, 175, 20, 250, 15);
				ctx.moveTo(10, 15);
				ctx.quadraticCurveTo(100, 100, 250, 15);
				ctx.stroke();

			*/
			   /* ��� �� ���� ����������� ���� �� ������ ���� ������, � ������ ����� �������������, ��� ��������
					fillStyle = color   // ���������� ���� �������
					strokeStyle = color // ���� ����� ���� �������� ����� ��� �� ��� � css, �� ������� ��� ������ ������� ������� �����

					// ��� ������ ������ ������ ��������� ���� �������:
					ctx.fillStyle = "orange";
					ctx.fillStyle = "#FFA500";
					ctx.fillStyle = "rgb(255,165,0)";
					ctx.fillStyle = "rgba(255,165,0,1)"
				*/

			   /*
			   ���������� ����������� ������� ����� ��������� �� ��� ����: �������� JavaScript ������� Image, � ������ � �������������� ��� ��� ��������� ����������� �� ������ ��� ������ ������� drawImage. ���������� ��� ���� ���������.

				�������� ������ ������������ �������:
				var img = new Image();  // �������� ������ ������� �����������
				img.src = 'image.png';  // ���� � ����������� ������� ���������� ������� �� �����

				������ � �������� ��������� �����������, ����� ������� ��� ����� ������ � ������� ����������� � ��������:
				imgSrc = 'data:image/gif;base64,R0lGODlhDAAMAOYAANPe5Pz//4KkutDb4szY3/b+/5u5z/3//3KWrfn//8rk8naasYGku
				*/
			   /*
				drawImage(image, x, y) - x � y ��� ���������� ������ �������� ���� �����������, � ������ �������� ��� �� ����������� ������� ������ ���� ����������

				drawImage(image, x, y, width, height)  // ����� ��������� img - width, height ������ ������ � ������ �����������

				drawImage(image, sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight) - ����������� ������� ��������
					sx, sy, sWidth, sHeight ��� ��������� ��������� �� �����������-���������,
					dx, dy, dWidth, dHeight ��� ���������� ��������� ��������� �� ������


				�������� ����������� ���������� ����� ����� ���������� ������� ��������� �����������, � ���� ��� �� ���������� ��������� � ������� ������ ������� ���������, �� ��� �������� �� ����� ���������� �� ������. ��� ��������� ���� �������� ������������ ����� �����������:

				var img = new Image();  // ����� ������
				img.onload = function(){  // ������� ������� ����� ��������� ����� ����������� ����� ��������� ���������
				}
				img.src = 'myImage.png';  // ���� � �����������
				*/
	/*             var pic = new Image();  // "������" �����������
				pic.src = 'http://habrahabr.ru/i/nocopypast.png';  // �������� �����������
				pic.onload = function() {  //��� ��������
				  //ctx.drawImage(pic, 0, 0);  // ������ ����������� �� ����� � ������������ 0, 0
				  //ctx.drawImage(pic, 0, 0, 300, 150);//����������� img
				  ctx.drawImage(pic, 25, 42, 85, 55, 0, 0, 170, 110);//������ ������� ������
				}*/


				/*******************
					������ �����:
				********************
				cellSize = 32;// ������ ����� ������ �� �����
				example.width = 8*cellSize;// ������ ������� ������ 8�8 ������
				example.height = 8*cellSize;
				// ����� ������ ��������� ��������
				// ������ � ������ ���������� ����� ������ � �������� �����������
				var map =
				  [
					[{x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}],  // 1�� ��� �����
					[{x:1, y: 4}, {x:1, y: 1}, {x:2, y: 1}, {x:3, y: 1}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}],  // 2�� ��� �����
					[{x:1, y: 4}, {x:1, y: 2}, {x:2, y: 2}, {x:3, y: 2}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}],  // 3�� ��� �����
					[{x:1, y: 4}, {x:3, y: 4}, {x:2, y: 3}, {x:3, y: 4}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 4}, {x:1, y: 4}],  // 4�� ��� �����
					[{x:1, y: 4}, {x:3, y: 4}, {x:2, y: 4}, {x:3, y: 4}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 4}, {x:1, y: 4}],  // 5�� ��� �����
					[{x:1, y: 4}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 4}, {x:1, y: 4}],  // 6�� ��� �����
					[{x:1, y: 4}, {x:1, y: 4}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 3}, {x:1, y: 4}, {x:1, y: 4}],  // 7�� ��� �����
					[{x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}, {x:1, y: 4}]   // 8�� ��� �����
				  ];

				var pic = new Image();  // "������" �����������
				pic.src = 'http://dl.dropbox.com/u/8307275/p/set.png';  // �������������� ��������
				pic.onload = function() {  // ������� onLoad, ��� ������� ���� ���������� �����������
				  for (var j=0; j<8; j++)
					for (var i=0; i<8; i++)
					  // ���������� ��� �������� ������� '�����' � � ����������� �� ��������� ������������ ������ ��� ��������
					  ctx.drawImage(pic, (map[i][j].x-1)*cellSize, (map[i][j].y-1)*cellSize, 32, 32, j*cellSize, i*cellSize, 32, 32);  // ������ ����������� �� ����� � ������������ 0, 0
				}*/
				/*$('.dot').mouseup( function(){
					//���������� �������� ��������� �������
				});*/
			});
		</script>
	</head>
	<body>
		<!-- <p>��� ���� <a href="http://www.benjoffe.com/code/demos/canvascape"> ��������</a></p>
		<br/> -->
		<div id="wrapper">
			<div id="wrapper-text">
				 Daldosa!
			</div>
			<canvas height='480' width='640' id='c'>�������� �������</canvas>
			<div class="ship">
			</div>
			<span class="dot">&#9829;</span>
		</div>
	</body>
</html>