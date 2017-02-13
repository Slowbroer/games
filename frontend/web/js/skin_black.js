/*登录输入账号失焦时触发*/
$(".in_txt").blur(function() {
	$(".code").show();
	$(".autologin").hide();
});

/*设置活动时间倒计时 begin*/
var interval = 1000; 
function ShowCountDown(year,month,day,hour,minute,second,divname) { 
	var now = new Date(); 
	var endDate = new Date(year, month-1, day,hour,minute,second); 
	var leftTime=endDate.getTime()-now.getTime(); 
	//计算秒数
	var leftsecond = parseInt(leftTime/1000); 
	var day1=Math.floor(leftsecond/(60*60*24)); 
	var hour1=Math.floor((leftsecond-day1*24*60*60)/3600); 
	var minute1=Math.floor((leftsecond-day1*24*60*60-hour1*3600)/60); 
	var second1=Math.floor(leftsecond-day1*24*60*60-hour1*3600-minute1*60); 
	var cc = document.getElementById(divname); 
	cc.innerHTML = day1+"天"+hour1+"小时"+minute1+"分"+second1+"秒"; 
}
window.setInterval(
	function(){
		ShowCountDown(2017,2,9,14,30,0,'time1');//后台传入截止时间
		ShowCountDown(2017,3,9,18,30,45,'time2');
	}, 
	interval);  
/*设置活动时间倒计时 end*/





/*星星评分*/
$(function(){
	/*鼠标经过*/
	$(document).on('mouseover', 'span[star]', function(event) {
		var num = $(this).index();
		console.log(num);
		var pmark = $(this).parent(".starwp");
		var mark = pmark.prevAll("input");
		var list = pmark.find('span');
		for(var i =0; i <=num;i++){
			list.eq(i).attr('class', 'star_on');
		}
		for(var i=num+1;i<=list.length-1;i++){
			list.eq(i).attr('class', 'star');
		}
	});
	/*鼠标移出*/
	$(document).on('mouseout', 'span[star]', function(event) {
		var num = $(this).index();
		console.log(num);
		var pmark = $(this).parent(".starwp");
		var mark = pmark.prevAll("input");
		var val = mark.val();
		var list = pmark.find('span');
		if (val != 0) {
			for(var i =0;i<val;i++){
				list.eq(i).attr('class', 'star_on');
			}
			for(var i=val;i<=list.length-1;i++){
				list.eq(i).attr('class', 'star');
			}
		}else{
			for(var i =0;i<=list.length-1;i++){
				list.eq(i).attr('class', 'star');
			}
		}
		
	});
	/*鼠标点击*/
	$(document).on('click', 'span[star]', function(event) {
		var num = $(this).index();
		var pmark = $(this).parent(".starwp");
		var mark = pmark.prevAll("input");
		mark.val(num+1);
		console.log(num+1);
	});
})

/*tab切换*/
$(".tab").mouseover(function(){
	$(this).addClass('cur');
	$(this).prevAll().removeClass("cur");
	$(this).nextAll().removeClass("cur");
	var tab_num = $(this).index();
	var cont_item = $(this).parent(".tab_type").siblings('.tab_con').children('.cont_item');
	for(var i =0;i<cont_item.length;i++){
		if (tab_num == i) {
			cont_item.eq(i).show();
			cont_item.eq(i).prevAll().hide();
			cont_item.eq(i).nextAll().hide();
		};
	}
})