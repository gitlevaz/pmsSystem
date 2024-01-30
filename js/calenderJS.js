
var todayStringFormat = '[todayString] [UCFdayString]. [day]. [monthString] [year]';						
var pathToImages = './images/';	// Relative to your HTML file

var speedOfSelectBoxSliding = 200;	// Milliseconds between changing year and hour when holding mouse over "-" and "+" - lower value = faster
var intervalSelectBox_minutes = 5;	// Minute select box - interval between each option (5 = default)

var calendar_offsetTop = 0;		// Offset - calendar placement - You probably have to modify this value if you're not using a strict doctype
var calendar_offsetLeft = 0;	// Offset - calendar placement - You probably have to modify this value if you're not using a strict doctype
var calendarDiv = false;
var MSIE = false;
var Opera = false;
if(navigator.userAgent.indexOf('MSIE')>=0 && navigator.userAgent.indexOf('Opera')<0)MSIE = true;
if(navigator.userAgent.indexOf('Opera')>=0)Opera = true;

var monthArray = ['January','February','March','April','May','June','July','August','September','October','November','December'];
var monthArrayShort = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
var dayArray = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
var weekString = 'Week';
var todayString = '';
var daysInMonthArray = [31,28,31,30,31,30,31,31,30,31,30,31];
var currentMonth;
var currentYear;
var currentHour;
var currentMinute;
var calendarContentDiv;
var returnDateTo;
var returnFormat;
var activeSelectBoxMonth;
var activeSelectBoxYear;
var iframeObj = false;
var iframeObj2 =false;

function EIS_FIX_EI1(where2fixit){
    iframeObj2.style.display = 'block';
    iframeObj2.style.height =document.getElementById(where2fixit).offsetHeight+1;
    iframeObj2.style.width=document.getElementById(where2fixit).offsetWidth;
    iframeObj2.style.left=getleftPos(document.getElementById(where2fixit))+1;
    iframeObj2.style.top=getTopPos(document.getElementById(where2fixit))-document.getElementById(where2fixit).offsetHeight;
}

function EIS_Hide_Frame(){
    iframeObj2.style.display = 'none';
}

var returnDateToYear;
var returnDateToMonth;
var returnDateToDay;
var inputYear;
var inputMonth;
var inputDay;
var selectBoxHighlightColor = '#D60808'; // Highlight color of select boxes
var selectBoxRolloverBgColor = '#B8D5EF'; // Background color on drop down lists(rollover)
var selectBoxMovementInProgress = false;
var activeSelectBox = false;

function cancelCalendarEvent(){
    return false;
}
function isLeapYear(inputYear){
    if(inputYear%400==0||(inputYear%4==0&&inputYear%100!=0)) return true;
    return false;	
}

var activeSelectBoxMonth = false;
var activeSelectBoxDirection = false;

function highlightMonthYear(){
    if(activeSelectBoxMonth)activeSelectBoxMonth.className='';
    activeSelectBox = this;

    if(this.className=='monthYearActive'){
        this.className='';	
    }else{
        this.className = 'monthYearActive';
        activeSelectBoxMonth = this;
    }

    if(this.innerHTML.indexOf('-')>=0 || this.innerHTML.indexOf('+')>=0){
        if(this.className=='monthYearActive')
            selectBoxMovementInProgress = true; 
        else 
            selectBoxMovementInProgress = false;	
        if(this.innerHTML.indexOf('-')>=0)activeSelectBoxDirection = -1; else activeSelectBoxDirection = 1;	
    }else selectBoxMovementInProgress = false;	
}

function showMonthDropDown(){
    if(document.getElementById('monthDropDown').style.display=='block'){
        document.getElementById('monthDropDown').style.display='none';			
        EIS_Hide_Frame();
    }
    else{
        document.getElementById('monthDropDown').style.display='block';		
        document.getElementById('yearDropDown').style.display='none';
        if (MSIE){
            EIS_FIX_EI1('monthDropDown')
        }
    }
}

function showYearDropDown(){
    if(document.getElementById('yearDropDown').style.display=='block'){
        document.getElementById('yearDropDown').style.display='none';	
        EIS_Hide_Frame();
    }
    else{
        document.getElementById('yearDropDown').style.display='block';	
        document.getElementById('monthDropDown').style.display='none';	
        if (MSIE){
            EIS_FIX_EI1('yearDropDown')
        }
    }		
}

function selectMonth(){
    document.getElementById('calendar_month_txt').innerHTML = this.innerHTML
    currentMonth = this.id.replace(/[^\d]/g,'');

    document.getElementById('monthDropDown').style.display='none';	
    EIS_Hide_Frame();
    for(var no=0;no<monthArray.length;no++){
            document.getElementById('monthDiv_'+no).style.color='';	
    }
    this.style.color = selectBoxHighlightColor;
    activeSelectBoxMonth = this;
    writeCalendarContent();	
}

function selectYear(){
    document.getElementById('calendar_year_txt').innerHTML = this.innerHTML;
    currentYear = this.innerHTML.replace(/[^\d]/g,'');
    document.getElementById('yearDropDown').style.display='none';
    EIS_Hide_Frame();
    if(activeSelectBoxYear){
            activeSelectBoxYear.style.color='';
    }
    activeSelectBoxYear=this;
    this.style.color = selectBoxHighlightColor;
    writeCalendarContent();	
}

function switchMonth(){
    if(this.src.indexOf('left')>=0){
        currentMonth=currentMonth-1;
        if(currentMonth<0){
            currentMonth=11;
            currentYear=currentYear-1;
        }
    }
    else{
        currentMonth=currentMonth+1;;
        if(currentMonth>11){
            currentMonth=0;
            currentYear=currentYear/1+1;
        }	
    }		
    writeCalendarContent();	
}

function createMonthDiv(){
    var div = document.createElement('DIV');
    div.className='monthYearPicker';
    div.id = 'monthPicker';

    for(var no=0;no<monthArray.length;no++){
        var subDiv = document.createElement('DIV');
        subDiv.innerHTML = monthArray[no];
        subDiv.onmouseover = highlightMonthYear;
        subDiv.onmouseout = highlightMonthYear;
        subDiv.onclick = selectMonth;
        subDiv.id = 'monthDiv_' + no;
        subDiv.style.width = '56px';
        subDiv.onselectstart = cancelCalendarEvent;		
        div.appendChild(subDiv);
        if(currentMonth && currentMonth==no){
            subDiv.style.color = selectBoxHighlightColor;
            activeSelectBoxMonth = subDiv;
        }			
    }	
    return div;	
}

function changeSelectBoxYear(e,inputObj){
    if(!inputObj)inputObj =this;
    var yearItems = inputObj.parentNode.getElementsByTagName('DIV');
    if(inputObj.innerHTML.indexOf('-')>=0){
        var startYear = yearItems[1].innerHTML/1 -1;
        if(activeSelectBoxYear){
            activeSelectBoxYear.style.color='';
        }
    }else{
        var startYear = yearItems[1].innerHTML/1 +1;
        if(activeSelectBoxYear){
            activeSelectBoxYear.style.color='';
        }			
    }
    for(var no=1;no<yearItems.length-1;no++){
        yearItems[no].innerHTML = startYear+no-1;	
        yearItems[no].id = 'yearDiv' + (startYear/1+no/1-1);			
    }		
    if(activeSelectBoxYear){
        activeSelectBoxYear.style.color='';
        if(document.getElementById('yearDiv'+currentYear)){
            activeSelectBoxYear = document.getElementById('yearDiv'+currentYear);
            activeSelectBoxYear.style.color=selectBoxHighlightColor;
        }
    }
}

function updateYearDiv(){
    var div = document.getElementById('yearDropDown');
    var yearItems = div.getElementsByTagName('DIV');
    for(var no=1;no<yearItems.length-1;no++){
        yearItems[no].innerHTML = currentYear/1 -6 + no;	
        if(currentYear==(currentYear/1 -6 + no)){
            yearItems[no].style.color = selectBoxHighlightColor;
            activeSelectBoxYear = yearItems[no];				
        }
        else{
            yearItems[no].style.color = '';
        }
    }		
}

function updateMonthDiv(){        
    for(no=0;no<12;no++){
    	document.getElementById('monthDiv_' + no).style.color = '';
    }    
    document.getElementById('monthDiv_' + currentMonth).style.color = selectBoxHighlightColor;    
    activeSelectBoxMonth = document.getElementById('monthDiv_' + currentMonth);    
}

function createYearDiv(){
    if(!document.getElementById('yearDropDown')){
        var div = document.createElement('DIV');
        div.className='monthYearPicker';
    }else{
        var div = document.getElementById('yearDropDown');
        var subDivs = div.getElementsByTagName('DIV');
        for(var no=0;no<subDivs.length;no++){
            subDivs[no].parentNode.removeChild(subDivs[no]);	
        }	
    }		
    var d = new Date();
    if(currentYear){
        d.setFullYear(currentYear);	
    }
    var startYear = d.getFullYear()/1 - 5;	
    var subDiv = document.createElement('DIV');
    subDiv.innerHTML = '&nbsp;&nbsp;- ';
    subDiv.onclick = changeSelectBoxYear;
    subDiv.onmouseover = highlightMonthYear;
    subDiv.onmouseout = function(){ selectBoxMovementInProgress = false;};	
    subDiv.onselectstart = cancelCalendarEvent;			
    div.appendChild(subDiv);

    for(var no=startYear;no<(startYear+10);no++){
        var subDiv = document.createElement('DIV');
        subDiv.innerHTML = no;
        subDiv.onmouseover = highlightMonthYear;
        subDiv.onmouseout = highlightMonthYear;		
        subDiv.onclick = selectYear;		
        subDiv.id = 'yearDiv' + no;	
        subDiv.onselectstart = cancelCalendarEvent;	
        div.appendChild(subDiv);
        if(currentYear && currentYear==no){
            subDiv.style.color = selectBoxHighlightColor;
            activeSelectBoxYear = subDiv;
        }			
    }
    var subDiv = document.createElement('DIV');
    subDiv.innerHTML = '&nbsp;&nbsp;+ ';
    subDiv.onclick = changeSelectBoxYear;
    subDiv.onmouseover = highlightMonthYear;
    subDiv.onmouseout = function(){ selectBoxMovementInProgress = false;};		
    subDiv.onselectstart = cancelCalendarEvent;			
    div.appendChild(subDiv);		
    return div;
}

/* This function creates the hour div at the bottom bar */
function slideCalendarSelectBox(){
    if(selectBoxMovementInProgress){
        if(activeSelectBox.parentNode.id=='yearDropDown'){
            changeSelectBoxYear(false,activeSelectBox);			
        }		
    }
    setTimeout('slideCalendarSelectBox()',speedOfSelectBoxSliding);		
}

function createHourDiv(){
    var div = document.createElement('DIV');
    div.className='monthYearPicker';
    return div;	
}

function highlightSelect(){	
    if(this.className=='selectBox'){
        this.className = 'selectBoxOver';	
        this.getElementsByTagName('IMG')[0].src = pathToImages + 'down_over.gif';
    }else if(this.className=='selectBoxOver'){
        this.className = 'selectBox';	
        this.getElementsByTagName('IMG')[0].src = pathToImages + 'down.gif';			
    }	
}

function highlightArrow(){
    if(this.src.indexOf('over')>=0){
        if(this.src.indexOf('left')>=0)this.src = pathToImages + 'left.gif';	
        if(this.src.indexOf('right')>=0)this.src = pathToImages + 'right.gif';				
    }else{
        if(this.src.indexOf('left')>=0)this.src = pathToImages + 'left_over.gif';	
        if(this.src.indexOf('right')>=0)this.src = pathToImages + 'right_over.gif';	
    }
}

function highlightClose(){
    if(this.src.indexOf('over')>=0){
        this.src = pathToImages + 'close.gif';
    }else{
        this.src = pathToImages + 'close_over.gif';	
    }	
}

function closeCalendar(){
    document.getElementById('yearDropDown').style.display='none';
    document.getElementById('monthDropDown').style.display='none';	

    calendarDiv.style.display='none';
    if(iframeObj){
        iframeObj.style.display='none';
        EIS_Hide_Frame();
    }
    if(activeSelectBoxMonth)activeSelectBoxMonth.className='';
    if(activeSelectBoxYear)activeSelectBoxYear.className='';
}

function writeTopBar(){
    var topBar = document.createElement('DIV');
    topBar.className = 'topBar';
    topBar.id = 'topBar';
    calendarDiv.appendChild(topBar);

    // Left arrow
    var leftDiv = document.createElement('DIV');
    leftDiv.style.marginRight = '1px';
    var img = document.createElement('IMG');
    img.src = pathToImages + 'left.gif';
    img.onmouseover = highlightArrow;
    img.onclick = switchMonth;
    img.onmouseout = highlightArrow;
    leftDiv.appendChild(img);	
    topBar.appendChild(leftDiv);
    if(Opera)leftDiv.style.width = '16px';

    // Right arrow
    var rightDiv = document.createElement('DIV');
    rightDiv.style.marginRight = '1px';
    var img = document.createElement('IMG');
    img.src = pathToImages + 'right.gif';
    img.onclick = switchMonth;
    img.onmouseover = highlightArrow;
    img.onmouseout = highlightArrow;
    rightDiv.appendChild(img);
    if(Opera)rightDiv.style.width = '16px';
    topBar.appendChild(rightDiv);

    // Month selector
    var monthDiv = document.createElement('DIV');
    monthDiv.id = 'monthSelect';
    monthDiv.onmouseover = highlightSelect;
    monthDiv.onmouseout = highlightSelect;
    monthDiv.onclick = showMonthDropDown;
    var span = document.createElement('SPAN');		
    span.innerHTML = monthArray[currentMonth];
    span.id = 'calendar_month_txt';
    monthDiv.appendChild(span);

    var img = document.createElement('IMG');
    img.src = pathToImages + 'down.gif';
    img.style.position = 'absolute';
    img.style.right = '0px';
    monthDiv.appendChild(img);
    monthDiv.className = 'selectBox';
    if(Opera){
        img.style.cssText = 'float:right;position:relative';
        img.style.position = 'relative';
        img.style.styleFloat = 'right';
    }
    topBar.appendChild(monthDiv);

    var monthPicker = createMonthDiv();
    monthPicker.style.left = '37px';
    monthPicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
    monthPicker.style.width ='60px';
    monthPicker.id = 'monthDropDown';

    calendarDiv.appendChild(monthPicker);

    // Year selector
    var yearDiv = document.createElement('DIV');
    yearDiv.onmouseover = highlightSelect;
    yearDiv.onmouseout = highlightSelect;
    yearDiv.onclick = showYearDropDown;
    var span = document.createElement('SPAN');		
    span.innerHTML = currentYear;
    span.id = 'calendar_year_txt';
    yearDiv.appendChild(span);
    topBar.appendChild(yearDiv);

    var img = document.createElement('IMG');
    img.src = pathToImages + 'down.gif';
    yearDiv.appendChild(img);
    yearDiv.className = 'selectBox';

    if(Opera){
        yearDiv.style.width = '50px';
        img.style.cssText = 'float:right';
        img.style.position = 'relative';
        img.style.styleFloat = 'right';
    }	

    var yearPicker = createYearDiv();
    yearPicker.style.left = '113px';
    yearPicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
    yearPicker.style.width = '35px';
    yearPicker.id = 'yearDropDown';
    calendarDiv.appendChild(yearPicker);	

    var img = document.createElement('IMG');
    img.src = pathToImages + 'close.gif';
    img.style.styleFloat = 'right';
    img.onmouseover = highlightClose;
    img.onmouseout = highlightClose;
    img.onclick = closeCalendar;
    topBar.appendChild(img);
    if(!document.all){
        img.style.position = 'absolute';
        img.style.right = '2px';
    }
}

function writeCalendarContent(){
    var calendarContentDivExists = true;
    if(!calendarContentDiv){
        calendarContentDiv = document.createElement('DIV');
        calendarDiv.appendChild(calendarContentDiv);
        calendarContentDivExists = false;
    }
    currentMonth = currentMonth/1;
    var d = new Date();	

    d.setFullYear(currentYear);		
    d.setDate(1);		
    d.setMonth(currentMonth);

    var dayStartOfMonth = d.getDay();
    if(dayStartOfMonth==0)dayStartOfMonth=7;
    dayStartOfMonth--;

    document.getElementById('calendar_year_txt').innerHTML = currentYear;
    document.getElementById('calendar_month_txt').innerHTML = monthArray[currentMonth];	

    var existingTable = calendarContentDiv.getElementsByTagName('TABLE');
    if(existingTable.length>0){
        calendarContentDiv.removeChild(existingTable[0]);
    }

    var calTable = document.createElement('TABLE');
    calTable.cellSpacing = '0';
    calendarContentDiv.appendChild(calTable);
    var calTBody = document.createElement('TBODY');
    calTable.appendChild(calTBody);
    var row = calTBody.insertRow(-1);
    var cell = row.insertCell(-1);
    cell.innerHTML = weekString;
    cell.style.backgroundColor = selectBoxRolloverBgColor;

    for(var no=0;no<dayArray.length;no++){
        var cell = row.insertCell(-1);
        cell.innerHTML = dayArray[no]; 
    }

    var row = calTBody.insertRow(-1);
    var cell = row.insertCell(-1);
    cell.style.backgroundColor = selectBoxRolloverBgColor;
    var week = getWeek(currentYear,currentMonth,1);
    cell.innerHTML = week;		// Week
    for(var no=0;no<dayStartOfMonth;no++){
        var cell = row.insertCell(-1);
        cell.innerHTML = '&nbsp;';
    }

    var colCounter = dayStartOfMonth;
    var daysInMonth = daysInMonthArray[currentMonth];
    if(daysInMonth==28){
        if(isLeapYear(currentYear))daysInMonth=29;
    }

    for(var no=1;no<=daysInMonth;no++){
            d.setDate(no-1);
            if(colCounter>0 && colCounter%7==0){
                var row = calTBody.insertRow(-1);
                var cell = row.insertCell(-1);
                var week = getWeek(currentYear,currentMonth,no);
                cell.innerHTML = week;		// Week	
                cell.style.backgroundColor = selectBoxRolloverBgColor;			
            }
            var cell = row.insertCell(-1);
            if(currentYear==inputYear && currentMonth == inputMonth && no==inputDay){
                cell.className='activeDay';	
            }
            cell.innerHTML = no;
            cell.onclick = pickDate;
            colCounter++;
    }	

    if(!document.all){
        if(calendarContentDiv.offsetHeight)
            document.getElementById('topBar').style.top = calendarContentDiv.offsetHeight + document.getElementById('topBar').offsetHeight -1 + 'px';
        else{
            document.getElementById('topBar').style.top = '';
            document.getElementById('topBar').style.bottom = '0px';
        }			
    }	
    if(iframeObj){
        if(!calendarContentDivExists)setTimeout('resizeIframe()',350);else setTimeout('resizeIframe()',10);
    }	
}

function resizeIframe(){
    iframeObj.style.width = calendarDiv.offsetWidth + 'px';
    iframeObj.style.height = calendarDiv.offsetHeight + 'px' ;		
}

function pickTodaysDate(){
    var d = new Date();
    currentMonth = d.getMonth();
    currentYear = d.getFullYear();
    pickDate(false,d.getDate());	
}

function pickDate(e,inputDay){
    var month = currentMonth/1 +1;
    if(month<10)month = '0' + month;
    var day;
    if(!inputDay && this)day = this.innerHTML; else day = inputDay;

    if(day/1<10)day = '0' + day;
    if(returnFormat){
        returnFormat = returnFormat.replace('dd',day);
        returnFormat = returnFormat.replace('mm',month);
        returnFormat = returnFormat.replace('yyyy',currentYear);		
        returnFormat = returnFormat.replace('d',day/1);
        returnFormat = returnFormat.replace('m',month/1);
        returnDateTo.value = returnFormat;
    }
    else{
        document.getElementById('txtYear').value=currentYear;
        document.getElementById('txtMonth').value= month;					
        document.getElementById('txtDay').value = day;		
    }
    closeCalendar();	
}

// This function is from http://www.codeproject.com/csharp/gregorianwknum.asp
// Only changed the month add
function getWeek(year,month,day){
    day = day/1;
    year = year /1;
    month = month/1 + 1; //use 1-12
    var a = Math.floor((14-(month))/12);
    var y = year+4800-a;
    var m = (month)+(12*a)-3;
    var jd = day + Math.floor(((153*m)+2)/5) + (365*y) + Math.floor(y/4) - Math.floor(y/100) + Math.floor(y/400) - 32045;// (gregorian calendar)
    var d4 = (jd+31741-(jd%7))%146097%36524%1461;
    var L = Math.floor(d4/1460);
    var d1 = ((d4-L)%365)+L;
    NumberOfWeek = Math.floor(d1/7) + 1;
    return NumberOfWeek;        
}

function writeBottomBar(){
    var d = new Date();
    var bottomBar = document.createElement('DIV');		
    bottomBar.id = 'bottomBar';	
    bottomBar.style.cursor = 'pointer';
    bottomBar.className = 'todaysDate';	
    var subDiv = document.createElement('DIV');
    subDiv.onclick = pickTodaysDate;
    subDiv.id = 'todaysDateString';
    subDiv.style.width = (calendarDiv.offsetWidth - 8) + 'px';
    var day = d.getDay();
    if(day==0)day = 7;
    day--;

    var bottomString = todayStringFormat;
    bottomString = bottomString.replace('[monthString]',monthArrayShort[d.getMonth()]);
    bottomString = bottomString.replace('[day]',d.getDate());
    bottomString = bottomString.replace('[year]',d.getFullYear());
    bottomString = bottomString.replace('[dayString]',dayArray[day].toLowerCase());
    bottomString = bottomString.replace('[UCFdayString]',dayArray[day]);
    bottomString = bottomString.replace('[todayString]',todayString);	

    subDiv.innerHTML = todayString + ': ' + d.getDate() + '. ' + monthArrayShort[d.getMonth()] + ', ' +  d.getFullYear() ;
    subDiv.innerHTML = bottomString ;
    bottomBar.appendChild(subDiv);		
    calendarDiv.appendChild(bottomBar);			
}

function getTopPos(inputObj){	
  var returnValue = inputObj.offsetTop + inputObj.offsetHeight;
  while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetTop;
  return returnValue + calendar_offsetTop;
}

function getleftPos(inputObj){
  var returnValue = inputObj.offsetLeft;
  while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetLeft;
  return returnValue + calendar_offsetLeft;
}

function positionCalendar(inputObj){
    calendarDiv.style.left = getleftPos(inputObj) + 'px';
    calendarDiv.style.top = getTopPos(inputObj) + 'px';
    if(iframeObj){
        iframeObj.style.left = calendarDiv.style.left;
        iframeObj.style.top =  calendarDiv.style.top;
        iframeObj2.style.left = calendarDiv.style.left;
        iframeObj2.style.top =  calendarDiv.style.top;
    }		
}
	
function initCalendar(){
    if(MSIE){
        iframeObj = document.createElement('IFRAME');
        iframeObj.style.position = 'absolute';
        iframeObj.border='0px';
        iframeObj.style.border = '0px';
        iframeObj.style.backgroundColor = '#FF0000';		
        iframeObj2 = document.createElement('IFRAME');
        iframeObj2.style.position = 'absolute';
        iframeObj2.border='0px';
        iframeObj2.style.border = '0px';
        iframeObj2.style.height = '1px';
        iframeObj2.style.width = '1px';
        document.body.appendChild(iframeObj2);		
        iframeObj2.src = 'blank.html'; 
        iframeObj.src = 'blank.html'; 
        document.body.appendChild(iframeObj);
    }		
    calendarDiv = document.createElement('DIV');	
    calendarDiv.id = 'calendarDiv';
    calendarDiv.style.zIndex = 1000;
    slideCalendarSelectBox();	
    document.body.appendChild(calendarDiv);	
    writeBottomBar();	
    writeTopBar();	

    if(!currentYear){
        var d = new Date();
        currentMonth = d.getMonth();
        currentYear = d.getFullYear();
    }
    writeCalendarContent();		
}

function calendarSortItems(a,b){
    return a/1 - b/1;
}

function displayCalendar(inputField,format,buttonObj){	    
    if(inputField.value.length>0){		
        if(!format.match(/^[0-9]*?$/gi)){
            var items = inputField.value.split(/[^0-9]/gi);
            var positionArray = new Array();
            positionArray['m'] = format.indexOf('mm');
            if(positionArray['m']==-1)positionArray['m'] = format.indexOf('m');
            positionArray['d'] = format.indexOf('dd');
            if(positionArray['d']==-1)positionArray['d'] = format.indexOf('d');
            positionArray['y'] = format.indexOf('yyyy');
            positionArray['h'] = format.indexOf('hh');
            positionArray['i'] = format.indexOf('ii');

            var positionArrayNumeric = Array();
            positionArrayNumeric[0] = positionArray['m'];
            positionArrayNumeric[1] = positionArray['d'];
            positionArrayNumeric[2] = positionArray['y'];
            positionArrayNumeric[3] = positionArray['h'];
            positionArrayNumeric[4] = positionArray['i'];			
			
            positionArrayNumeric = positionArrayNumeric.sort(calendarSortItems);
            var itemIndex = -1;
            currentHour = '00';
            currentMinute = '00';
            for(var no=0;no<positionArrayNumeric.length;no++){
                    if(positionArrayNumeric[no]==-1)continue;
                    itemIndex++;
                    if(positionArrayNumeric[no]==positionArray['m']){
                            currentMonth = items[itemIndex]-1;
                            continue;
                    }
                    if(positionArrayNumeric[no]==positionArray['y']){
                            currentYear = items[itemIndex];
                            continue;
                    }	
                    if(positionArrayNumeric[no]==positionArray['d']){
                            tmpDay = items[itemIndex];
                            continue;
                    }	
                    if(positionArrayNumeric[no]==positionArray['h']){
                            currentHour = items[itemIndex];
                            continue;
                    }	
                    if(positionArrayNumeric[no]==positionArray['i']){
                            currentMinute = items[itemIndex];
                            continue;
                    }	
            }
            currentMonth = currentMonth / 1;
            tmpDay = tmpDay / 1;
        }else{		
                var monthPos = format.indexOf('mm');
                currentMonth = inputField.value.substr(monthPos,2)/1 -1;	
                var yearPos = format.indexOf('yyyy');
                currentYear = inputField.value.substr(yearPos,4);		
                var dayPos = format.indexOf('dd');
                tmpDay = inputField.value.substr(dayPos,2);		
        }
    }else{
            var d = new Date();
            currentMonth = d.getMonth();
            currentYear = d.getFullYear();
            currentHour = '08';
            currentMinute = '00';
            tmpDay = d.getDate();
    }
	
    inputYear = currentYear;
    inputMonth = currentMonth;
    inputDay = tmpDay/1;	

    if(!calendarDiv){
        initCalendar();			
    }else{
        if(calendarDiv.style.display=='block'){
            closeCalendar();
            return false;
        }
        writeCalendarContent();
    }				
    returnFormat = format;
    returnDateTo = inputField;
    positionCalendar(buttonObj);
    calendarDiv.style.visibility = 'visible';	
    calendarDiv.style.display = 'block';	
    if(iframeObj){
        iframeObj.style.display = '';
        iframeObj.style.height = '140px';
        iframeObj.style.width = '195px';
        iframeObj2.style.display = '';
        iframeObj2.style.height = '140px';
        iframeObj2.style.width = '195px';
    }	
    updateYearDiv();
    updateMonthDiv();	
}

function displayCalendarSelectBox(yearInput,monthInput,dayInput,buttonObj){  
    if(monthInput.value > 12){
        alert("Month is > 12");
        yearInput.value = 2006; 
        monthInput.value = "01";
    }
    currentMonth = monthInput.value/1-1;
    currentYear = yearInput.value;	

    inputYear = yearInput.value;
    inputMonth = monthInput.value/1 - 1;
    inputDay = dayInput.value/1;

    if(!calendarDiv){
        initCalendar();			
    }else{
        writeCalendarContent();
    }			
    returnDateToYear = yearInput;
    returnDateToMonth = monthInput;
    returnDateToDay = dayInput;	

    returnFormat = false;
    returnDateTo = false;
    positionCalendar(buttonObj);
    calendarDiv.style.visibility = 'visible';	
    calendarDiv.style.display = 'block';
    if(iframeObj){
        iframeObj.style.display = '';
        iframeObj.style.height = calendarDiv.offsetHeight + 'px';
        iframeObj.style.width = calendarDiv.offsetWidth + 'px';			
        iframeObj2.style.display = '';
        iframeObj2.style.height = calendarDiv.offsetHeight + 'px';
        iframeObj2.style.width = calendarDiv.offsetWidth + 'px'
    }	
    updateYearDiv();
    updateMonthDiv();	
}
