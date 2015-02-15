<html>
	<head>
		<script src="http://code.jquery.com/jquery-1.8.2.min.js">//91.2 KB</script>
		<style type="text/css">
			body{
				margin: 0 auto;
				display: block;
			}
			#playing-area /*������� ��������*/
    {
     position : absolute;
     left : 10%; top : 10%; width : 80%; height : 80%;
     background-color : rgba(200,200,200,0.5);
     box-shadow: 0px 0px 20px #777;
     z-index:0;
    }

   #info /*�������������� ������*/
    {
     position : absolute;
     left : 0%; top : 0%; width : 10%; height : 100%;
     border : none;
     font-family : "trebuchet ms", Verdana, Tahoma, Arial, Sans-Serif;
     font-size : 18px;
     color : Dodgerblue;
    }

   #platform /*���������*/
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

   #platform p /*�������� ������ ���������*/
    {
      margin : 0;
      font-family : "trebuchet ms", Verdana, Tahoma, Arial, Sans-Serif;
      font-size : 14px;
      font-weight : bold;
      color : #777;
      text-align : center;
      text-shadow: #fff 1px 1px 2px;
    }

   #ball,.ball /*��� (� ���� � ��� ����������� ���������� �������)*/
    {
     position : absolute;
     width : 20px; height : 20px;
     background-color : #555;
     border-radius: 10px;
     box-shadow: inset 5px 0px 5px #fff;
     z-index:1;
    }

   .brick /*������*/
    {
     position : absolute;
     border : none;
     background-color : #bbb;
     border-radius: 5px;
     box-shadow: inset 0px 0px 10px #333;
     z-index:1;
    }

   .brick p /*�������� ������ �������*/
    {
      margin : 0;
      font-family : "trebuchet ms", Verdana, Tahoma, Arial, Sans-Serif;
      font-size : 14px;
      font-weight : bold;
      color : #777;
      text-align : center;
      text-shadow: #fff 1px 1px 2px;
    }

    h1 {/*����� ��� ������ ���������*/
      font-family : "trebuchet ms", Verdana, Tahoma, Arial, Sans-Serif;
      font-size : 20px;
      color : #777;
      text-align : center;
    }

   .copyright {/*���� ��� ������ ���������� �� ��������� �����*/
      position : absolute;
      left : 50%; top : 100%; width : 700px; height : 40px;
      margin-left : -350px;
      margin-top : -40px;
    }

   .copyright p {/*����� ��� ������ ���������� �� ��������� �����*/
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
/*------------------------------------��������� ������ ���� '��������'----------------------------------------------*/
   //JavaScript ������ '������� ��������' (playing area)
   function pa()
   {
     //�������� ������� �� id ���������� jQuery
     this.element = $("#playing-area");

     //����������� ������ ������� �������� � ������������ � ����������� ��������
     this.element.width(Math.round(this.element.width() / _bricks_line) * _bricks_line);
     this.element.height(Math.round(this.element.height() / _bricks_lines_max) * _bricks_lines_max);

     //��������� ��������� �������� � ��������
     this.offset = this.element.offset();
     this.width = this.element.width();
     this.height = this.element.height();

     //��������� ������� ������� '������'
     this.brick_width = Math.round(this.width / _bricks_line);
     this.brick_height = Math.round(this.height / _bricks_lines_max);

     //������� ���������� ���������-������� � ������
     this.platform = new platform(this);
     this.ball = new ball(this);

     //������ �������:
     //������� ������� '������' ���������� jQuery
     this.initBricks = function()
      {
       for (var i = 0; i < _bricks_lines; i++)
            for (var j = 0; j < _bricks_line; j++)
                 //����� prepend() ��������� �������� HTML � ����� ����������� ������� ��������
                 this.element.prepend("<div id='brick_"+i+"_"+j+"' class='brick' style='left:"+(j * this.brick_width + 1)+"px; top:"+(i * this.brick_height + 1)+"; width:"+(this.brick_width - 2)+"px; height: "+(this.brick_height - 2)+"px'><p>"
				      + (Math.round(Math.random() * (_bricks_lines - i)) + (_bricks_lines - i)) + "</p></div>");
      }

     //������� ���������� �������� arcanoid � ������ ����
     this.prepare = function()
      {
       this.try_count = _try_count_max;
       this.score = 0;

       //���� �������� ������� � �������� ������ ����, �� ��� �� ������� ���������� ������� jQuery
       $('.brick').remove();

       //������� ������� �� �����
       this.initBricks();
       //������������� ����� �� ���������
       this.ball.reset();
       //������� ���������� � ���������� ������� � �����
       this.showInfo();
      }

     //����� ���������� � ���������� ������� � �����
     this.showInfo =  function()
      {
       var _try_count_balls = "";
       for (var i = 0; i < this.try_count - 1; i++)
            _try_count_balls = _try_count_balls + "<div class='ball' style='position: relative; float: left;'></div>";

       $('#info').html("$" + this.score + "<br/>" + _try_count_balls);
      }
   }

   //JavaScript ������ '���������-�������'
   function platform(pa)
   {
     //���������� � �������������� �������� �������
     this.pa = pa;
     this.element = $("#platform"); //�������� ������� �� id ���������� jQuery
     this.width = this.element.width();
     this.height = this.element.height();
     this.interval = 0;
     this.dx = 0;
     this.last_x = 0;

     //������ �������:
     //���������� ������� ����������� ��������� (������������ ��� ������� '����������')
     this.evaluate_dx = function()
     {
       if (this.last_x > 0)
           this.dx = this.element.offset().left - this.last_x;

       this.last_x = this.element.offset().left;
     }

     //�����������
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

       //���� ����� � ��������� �����, �� ����������� ��� �� ������ ���������
       if (this.pa.ball.ready)
           this.pa.ball.setUp();
     }
   }

   //JavaScript ������ '�����'
   function ball(pa)
   {
     //���������� � �������������� �������� �������
     this.pa = pa;
     this.element = $("#ball"); //�������� ������� �� id ���������� jQuery
     this.width = this.element.width();
     this.height = this.element.height();
     this.interval = 0;
     this.ready = true;
     this.dx = 0;
     this.dy = 0;

     //������ �������:
     //������� ��������� ������
     this.kick = function()
     {
      if (this.dy > 0)
          this.dy = -this.dy;
      else
         {/*������ � ���������*/
          if (this.pa.platform.dx == 0)/*���� ��������� � �����, �� �������� �� ����������� �������������� ��������� �������*/
              this.dx = 2 - Math.round(Math.random() * 5);

          this.dy = -_ball_dy;
         }

      this.dx = this.dx + Math.round(this.pa.platform.dx / 5);

      //����������� �� �������� �� �����������
      if (Math.abs(this.dx) > _ball_dx_max)
          if (this.dx > 0)
              this.dx = _ball_dx_max;
          else
              this.dx = -_ball_dx_max;
      }

      //��������� ������ �� ������ ���������
      this.setUp = function()
      {
       this.element.offset({left:this.pa.platform.element.offset().left + this.pa.platform.width / 2 - this.width / 2, top:this.pa.platform.element.offset().top - this.height});
      }

      //��������� '�������' ������ - ���������� �����������, ��������� �� ��������� � ��������� ������� ��������
      this.reset = function()
      {
        if (this.interval)
            clearInterval(this.interval);

        this.setUp();

        this.dx = 0;
        this.dy = 0;
        this.ready = true;
      }

      //��������� ����������� ������
      this.move = function()
      {
       var _ball_offset = this.element.offset();
       var _platform_offset = this.pa.platform.element.offset();

       if ((_ball_offset.left < this.pa.offset.left && this.dx < 0) || (_ball_offset.left + this.width > this.pa.offset.left + this.pa.width && this.dx > 0))
           this.dx = -this.dx //���� � ������������ ������
       else if (_ball_offset.top < this.pa.offset.top && this.dy < 0)
                this.dy = -this.dy //���� � ������� ������
            else if (_ball_offset.top > _platform_offset.top - this.height  && this.dy > 0) //������� ���� ���������
                     if (_ball_offset.left > _platform_offset.left - this.width && _ball_offset.left < _platform_offset.left + this.pa.platform.width)
                        {//��������� ����������
                         this.kick();
                         this.pa.platform.element.fadeTo(200, 0.5, function(){$("#platform").fadeTo(200, 1)});
                        }
                     else //��������� ������� ������
                         {
                          this.pa.try_count--; //���������� ���������� �������

                          if (this.pa.try_count > 0)
                             {//����� � ����� ��������
                              this.pa.showInfo();
                              this.reset();
                             }
                          else //��������� ����
                             gameOver();

                          return;
                         }

       //��������� ��������� �� ��������:
       //��������� �������������� ���������� � ��������� ������
       var _ball_next_x = _ball_offset.left + this.dx;
       var _ball_next_y = _ball_offset.top + this.dy;
       //��������� ���������� ������� � ������� ��������� '�����-���'
       var _xindex = Math.floor((_ball_next_x - this.pa.offset.left) / this.pa.brick_width);
       var _yindex = Math.floor((_ball_next_y - this.pa.offset.top) / this.pa.brick_height);

       //���� ������� '������' ���������� ������� jQuery �� id
       var _bricks = $("#brick_"+_yindex+"_"+_xindex);
       if (_bricks.size() > 0)
           {
            var _brick = _bricks[0];
            //���� ������ �� � ��������� '��������', �� �������������� ��� �������� � ������������ ������
            if (typeof _brick.broken == "undefined")
               {
                //�������� ��������� ������� �������� ��������
                var _rect = _brick.getBoundingClientRect();

                //���������� ����������� �������
                if (_ball_offset.left > _rect.left - this.width && _ball_offset.top < _rect.left + _rect.width)
                   this.dy = -this.dy;
                else
                   this.dx = -this.dx;

                //�������� ������ ��� '���������'
                _brick.broken = true;
                //�������������� �������� �������� '������' ����� ��� ������������ ���������� jQuery
                $("#"+_brick.id).hide(200, function(){$("#"+this.id).remove()});

                //�������������� �������� ����� � ����������� ����� �� ������
                var _brickInnerText;
                if (_brick.innerText)
                   _brickInnerText = _brick.innerText
                else
                   _brickInnerText = _brick.textContent //��� Firefox

                //���������� ���� �� ������ � ��������� ���������
                var _brickScore = parseInt(_brickInnerText);

                if (!isNaN(_brickScore))
                    this.pa.score = this.pa.score + _brickScore;

                //��������� ����
                this.pa.showInfo();
                return;
              }
           }

       //����������� ������
       this.element.offset({left:_ball_offset.left + this.dx, top:_ball_offset.top + this.dy});
      }
   }

/*------------------------------------�������� ���--------------------------------------------------*/
//�������� ��������� ����
   const _bricks_line = 20;      //���������� �������� � ���� (���������� ������ �������)
   const _bricks_lines = 5;      //���������� ����� ��������
   const _bricks_lines_max = 20; //������������ ���������� ����� �������� (���������� ������ �������)
   const _ball_dy = 5;           //�������� ������ �� ���������
   const _ball_dx_max = 5;       //������������ �������� ������ �� ����������� (����������� ���������� '��������' ������ ����������-��������)
   const _try_count_max = 5;     //���������� ������� (�������)

//��������� ������� ��������
   var _pa;

//���������� �������
//������� ����
   function restart()
   {
     if (_pa.platform.interval)
         clearInterval(_pa.platform.interval);

     //���������� ��������
     _pa.prepare();
     //���������� ������� ����������� ��������� ������ 10 ��.
     _pa.platform.interval = window.setInterval(function() {_pa.platform.evaluate_dx()}, 10);
   }

//������ ������
   function launchBall()
   {
     //������ ������
     _pa.ball.kick();
     //����������� ������ ������ 10 ��.
     _pa.ball.interval = window.setInterval(function() {_pa.ball.move()}, 10);
     //����� � ��������� '������'
     _pa.ball.ready = false;
   }

//����� ����
   function gameOver()
   {
     alert("���� ��������. ���� ����: " + _pa.score);
     restart();
   }

//������������� �������� ������ '��������' ����� �������� �������� ���������� jQuery
   $(document).ready(function()
   {
     //������� ������� ��������
     _pa = new pa();

     //�������������� ����
     restart();

     //����������� ��������� ������� mousemove ���������� jQuery
     $(document).mousemove(function(event)
                  {
                   //��������������� ��������� �������
                   event = event || window.event;

                   //��������������� ��������� ��������� ���� � ����������� ���������
                   _pa.platform.move(event.pageX || event.x);
                  })

     //����������� ��������� ������� mousedown ���������� jQuery
     $(document).mousedown(function(event)
                  {
                    //���� ����� � ��������� '������', �� ������ �� ������
                    if (!_pa.ball.ready)
                        return;

                    //������ ������
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