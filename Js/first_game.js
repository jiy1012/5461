 var line;
 var style = new Array();
 var old_style = new Array();
 var use_time=0;
 var timer;
 function getimg(){
	$('#button').remove();//移除开始按钮
	line = $('#line').val();//行数
	$('#line').remove();//移除下拉框
	var img = $('#src_img').attr('src');
	var wid=$('#src_img').width();//图宽
	var hei=$('#src_img').height();//图高
	var tdwid = wid/line;//每一块宽
	var tdhei = hei/line;//每一块高
	var tds=new Array();
	for (i=0;i<line;i++)
	{
		tds[i]=new Array();
		for (j=0;j<line;j++)
		{
			tds[i][j]=new Array();
			tds[i][j][0]=-(0+i*tdhei);
			tds[i][j][1]=-(0+j*tdwid);
		}
	}
	for (i=0;i<line;i++)
	{
			for (j=0;j<line;j++)
		{
			var id='td_'+i+j;
			var width=tdwid+1;
			var height=tdhei+1;
			style[id]='width:'+width+'; height:'+height+';background:url('+img+') no-repeat '+tds[i][j][1]+'px '+tds[i][j][0]+'px ;'
			old_style=style;
		}
	}
	style = ShuffleArr(style);
	for (i=0;i<line;i++)
	{
			for (j=0;j<line;j++)
		{
			var id='td_'+i+j;
			$("#"+id).attr('style',style[id]);
		}
	}
	timedCount();
}


function playimg(i,j){
	var id =new Array();
	id[0]='td_'+i+j;
	id[1]='td_'+eval(i-1)+j;
	id[2]='td_'+eval(i+1)+j;
	id[3]='td_'+i+eval(j-1);
	id[4]='td_'+i+eval(j+1);
	var tdid='td_'+i+j;
	if (i-1<0){	id[1]=null;}
	if(j-1<0){	id[3]=null;}
	if (i+1>line-1){	id[2]=null;}
	if(j+1>line-1){	id[4]=null;}
	for (t=1;t<=4 ;t++ )
	{
		if (id[t]!=null)
		{
			var checked=document.getElementById(id[t]).className;
			if (checked=='select')
			{
				check=1;
				var last_id=id[t]
			}
		}
	}
	//本身是否被选中
	var checked_self=document.getElementById(tdid).className;
	if (checked_self=='select'){check=2;}
	if ("undefined" == typeof check)//上下左右四个没有select
	{
		for (m=0;m<line ;m++ )
		{
			for (n=0;n<line ;n++ )
			{
				var allid='td_'+m+n;
				$('#'+allid).removeClass('select')
			}
		}
		$('#'+tdid).addClass('select');
	}else if(check==2){//本身被选中
		$('#'+tdid).removeClass('select');
	}else if(check==1){//交换两块的样式
		var nowstyle=style[last_id];
		style[last_id]=style[tdid];
		style[tdid]=nowstyle;
		$("#"+tdid).attr('style',style[tdid]);
		$("#"+last_id).attr('style',style[last_id]);
		$('#'+tdid).removeClass('select');
		$('#'+last_id).removeClass('select');
		if (checkover(style,old_style)===true)
		{	
			clearInterval(timer);
			alert('恭喜你，完成！你花费的时间是'+$('#timer').val()+'，还需努力啊。。。');
		}
	}
	delete check;//重置check状态
}

//打亂數組
function ShuffleArr(arr){
	var arrkey = new Array();
	var arrval = new Array();
	for(str in arr){
		arrkey.push(str);
		arrval.push(arr[str]);
	}
	arrkey.sort(randomsort);
	arrval.sort(randomsort);
	newarr = new Array();
	for (i in arrkey){
		newarr[arrkey[arrkey.length-1-i]]=arrval[i];
	}
	return newarr;
}
//隨機數
function randomsort() {
        return Math.random()>0.5 ? -1 : 1;//用Math.random()函数生成0~1之间的随机数与0.5比较，返回-1或1
}
function checkover(style,old_style){
	for (key in style )
	{
		if (style[key]!=old_style[key])
		{
			return false;
		}
	}
	return true;
}
function timedCount()
{
	$('#timer').val(Math.ceil(use_time/10)+'.'+(use_time%10)+' 秒')
	use_time=use_time+1;
	timer=setTimeout("timedCount()",100)
}