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
	$(".info").find('.starwp').each(function(index, el) {
		var star_el = $(this).children('.star');
		star_el.hover(function() {
			$(this).addClass('star_on');
			$(this).prevAll().addClass('star_on');
			
		}, function() {
			$(this).removeClass('star_on');
			$(this).prevAll().removeClass('star_on');
		});
		star_el.click(function(event) {
			$(this).addClass('star_on');
			$(this).prevAll().addClass('star_on');
		});
		
	});		
})