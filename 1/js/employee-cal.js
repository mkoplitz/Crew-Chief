days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

date = new Date();
actualDate = new Date();
todaysDate = new Date();
month = date.getMonth();
year = date.getYear();
numberOfDaysInMonth = 0;

jobsPerDayArray = ["Jobs Per Day"];
appointments = [];
employees = [];
empDataObjects = [];
persistent = [];
selectedEmployees = [];

allowOpenDailyAppointments = true;
allowNewAppointment = true;
allowReload = false;
allowClick = true;

$(document).ready(function() {
  todaysDate.setHours(0, 0, 0, 0);
  $('#day-editor-container, #day-editor, #add-job-container, #add-job').css('display', 'none');
  $('#thanks-dawg').css('display', 'none');
  buildCalendar(date);
  getAppointments(year, month);
  console.log(appointments);
  getEmployeeData(year, month);
  drawRedAlerts();
  dropdownMenu();
  console.log(year, month);
});

function getAppointments(y, m) {
  var getAppointments = new XMLHttpRequest();
  getAppointments.onload = function() {
    appointmentData = (this.responseText).split("<newrecord>");
  }
  getAppointments.open("get", "php/get/get-appts.php?Year=" + y + "&Month=" + m, false);
  getAppointments.send();
  parseAppointments(appointmentData);
  console.log(appointmentData);
}

function parseAppointments(appointmentData) {
  appointments = [];
  for (i = 0; i < appointmentData.length - 1; i++) {
    each = appointmentData[i].split("/");
    appointments.push({
      jobID: each[0],
      client: each[1],
      jobtype: each[2],
      jobstart: each[3],
      jobend: each[4],
      apptYear: each[5],
      apptMonth: each[6],
      apptDay: each[7],
      notes: each[8]
    });
  }
  jobsPerDayArray = ["Jobs Per Day"];
  for (i = 1; i <= numberOfDaysInMonth; i++) {
    jobsPerDayArray.push(appointments.filter(function(obj) {
      return obj.apptDay == i;
    }).length);
  }
  console.log(jobsPerDayArray);
}

function getEmployeeData(y, m) {
  employeeData = [];
  var getEmployeeData = new XMLHttpRequest();
  getEmployeeData.onload = function() {
    employeeData = (this.responseText).split("<newrecord>");
  }
  getEmployeeData.open("get", "../php/get/get-bridge.php?y=" + y + "&m=" + m, false);
  getEmployeeData.send();
  parseEmployeeData(employeeData);
}

function parseEmployeeData(employeeData) {
  employees = [];
  for (i = 0; i < employeeData.length; i++) {
    each = employeeData[i].split('/');
    employees.push({
      job_id: each[0],
      emp_id: each[1],
      f_name: each[2],
      l_name: each[3]
    });
  }
}

function reload(id) {
  clearRedAlerts();
  drawRedAlerts();
  closeNewAppointmentWindow();
  $('.job-details-container').empty();
  addEachJobsContainers(id);
  fillTheThing(id);
}

function sortThisDaysAppointments(id) {
  thisDaysAppointments = appointments.filter(function(obj) {
    return obj.apptDay == (id);
  });
  thisDaysAppointments = thisDaysAppointments.sort(function(a, b) {
    return (a.jobstart) > (b.jobstart);
  });
}

function openDailyAppointments(id) {
  if (allowOpenDailyAppointments === true && jobsPerDayArray[id] >= 0) {
    allowOpenDailyAppointments = false;
    $('#day-editor-container, .day-editor').fadeIn(120);
    drawTheThing(id);
  }
}

function addEachJobsContainers(id) {
  for (i = 0; i < jobsPerDayArray[id]; i++) {
    $('.job-details-container').append('<div class="each-job-container ' + i + '"><div class="job-details-left" id="appointment' + i + '"></div><div class="job-details-right" id="employees' + i + '"></div></div>');
  }
}

function drawTheThing(id) {
  if (jobsPerDayArray[id] >= 0) { // Makes sure it's not a day that doesn't exist for that month
    selectedDate = new Date(year, month, id).setHours(0, 0, 0, 0);
    $('#day-overview').append('<div class="day-editor-button" id="close" onclick="closeDailyAppointments();"><image class="day-editor-button" src="../images/cancel.svg"></image></div>');

    $('#day-overview').append('<div class="month-and-day"></div>');
    $('.month-and-day').append('<h1>' + months[month] + ' ' + id + '</h1>');

    if (jobsPerDayArray[id] === 0) {
      $('.job-details-container').append('<h1>Nada</h1>');
    } else {
      addEachJobsContainers(id);
      fillTheThing(id);
    }
  }
}

function fillTheThing(id) {
  selectedDate = new Date(year, month, id).setHours(0, 0, 0, 0);
  sortThisDaysAppointments(id);
  for (i = 0; i < thisDaysAppointments.length; i++) {
    let appointmentsInfo = new Map(Object.entries(thisDaysAppointments[i]));

    y = appointmentsInfo.get('apptYear');
    m = appointmentsInfo.get('apptMonth');
    appointmentID = appointmentsInfo.get('jobID');

    startTime = appointmentsInfo.get('jobstart').slice(0, 5);
    endTime = appointmentsInfo.get('jobend').slice(0, 5);

    $('div.' + i).attr('id', appointmentID);

    if (appointmentsInfo.get('notes') !== "") {
      $('div.' + i).append('<div class="notes ' + i + '" id="' + appointmentID + '" onclick="showNotes(' + appointmentID + ');"><image id="notes" src="../images/x-point.svg"></image></div');
    }

    $('#appointment' + i).append('<h3>Details</h3><hr>');
    $('#employees' + i).append('<h3>Employees</h3><hr>');
    
    $('#appointment' + i).append('<p>Starts At: ' + startTime + '</p>');
    $('#appointment' + i).append('<p>Ends At: ' + endTime + '</p><br>');
    $('#appointment' + i).append('<p>Job Type: ' + appointmentsInfo.get('jobtype') + '</p>');
    $('#appointment' + i).append('<p>Client: ' + appointmentsInfo.get('client') + '</p>');

    
    employeesPerJob = employees.filter(function(obj) {
      return obj.job_id == appointmentID;
    });

    for (j = 0; j < employeesPerJob.length; j++) {
      $('#employees' + i).append(employeesPerJob[j].f_name + ' ' + employeesPerJob[j].l_name + '<br>');
    }
  }
  $('#loader-container').css('display', 'none');
}

function showNotes(appointmentID) {
  console.log('hey');
  thisAppointment = appointments.filter(function(obj) {
    return obj.jobID == (appointmentID);
  });
  alert(thisAppointment[0].notes);
}

function deleteAppointment(appointmentID, y, m) {
  $('#loader-container').css('display', 'block');
  var oReq = new XMLHttpRequest();
  oReq.open("get", "../php/delete/delete-appts.php?id=" + appointmentID, false);
  oReq.send();
  $('#' + appointmentID).remove();
  if ($('.each-job-container').length === 0) {
    $('.job-details-container').append('<br><br><h1>Nada</h1>');
  }
  $('#loader-container').css('display', 'none');
  getAppointments(y, m);
  getEmployeeData(y, m);
  clearRedAlerts();
  drawRedAlerts();
}

function closeDailyAppointments() {
  allowOpenDailyAppointments = true;
  $('#day-editor-container, .day-editor').fadeOut(160);
  setTimeout(function() {
    $('.day-editor-top').children('.day-editor-button').remove();
    $('.month-and-day, .job-details-left, .job-details-right').remove();
    $('.job-details-container').empty();
  }, 160);
}

function openNewAppointmentWindow(year, month, day) {
    $('#add-job-container, #add-job').fadeIn(120);
    $('#new-appt').append('<div id="send-it" onclick="addAppointment(' + year + ', ' + month + ', ' + day + ');"><image class="day-editor-button" src="../images/put-in-button.svg"></image></div>');
}

function closeNewAppointmentWindow() {
  allowNewAppointment = true;
  $('#add-job-container, #add-job').fadeOut(160);
  $('#new-appt').children('#send-it').remove();
  resetEmpLists();
}

function changeMonth(direction) {
  date.setMonth(date.getMonth() + direction, 10);
  month = date.getMonth();
  year = date.getFullYear();
  getAppointments(year, month);
  getEmployeeData(year, month);
  $('#calendar').empty();
  $('.month-and-arrows').remove();
  buildCalendar(date);
  drawRedAlerts();
}

function dropdownMenu() {
  // Clients
  clientData = [];
  var clientList = new XMLHttpRequest();
  clientList.onload = function() {
    rawClientData = (this.responseText).split("<newrecord>");
    for (i = 0; i < rawClientData.length - 1; i++) {
      each = rawClientData[i].split("/");
      clientData.push({
        id: each[0],
        client: each[1]
      });
    }
    clientData.filter(function(obj) {
      $('#client-dropdown select').append('<option value="' + obj.client + '">' + obj.client + '</option>');
    })
  }
  clientList.open("get", "../php/get/get-clients.php", false);
  clientList.send();

  // Job Types
  jobDataObjects = [];
  var jobList = new XMLHttpRequest();
    jobList.onload = function() {
    jobData = (this.responseText).split("<newrecord>");
    for (i = 0; i < jobData.length - 1; i++) {
      each = jobData[i].split("/");
      jobDataObjects.push({
        id: each[0],
        jobType: each[1]
      });
    }
    jobDataObjects.filter(function(obj) {
      $('#job-dropdown select').append('<option value="' + obj.jobType + '">' + obj.jobType + '</option>');
    })
  }
  jobList.open("get", "../php/get/get-jobs.php", true);
  jobList.send();

  getEmployees();

  // Start Time
  for (i = 0; i < 24; i++) {
    $('#start-time-dropdown').append('<option value="' + i + ':00">' + i + ':00</option>');
  }

  // End Time
  for (i = 0; i < 24; i++) {
    $('#end-time-dropdown').append('<option value="' + i + ':00">' + i + ':00</option>');
  }
}

function loadEmployeeLists() {
  empDataObjects.filter(function(obj) {
    $('#employee-field').append('<p class="select" value="' + obj.id + '" onclick="selectEmployee(' + obj.id + ')">' + obj.f_name + ' ' + obj.l_name + ' </p>');
  })
  selectedEmployees.filter(function(obj) {
    $('#employee-insert-field').append('<p class="select" value="' + obj.id + '" onclick="deselectEmployee(' + obj.id + ')">' + obj.f_name + ' ' + obj.l_name + ' </p>');
  })
}

function getEmployees() {
  var empList = new XMLHttpRequest();
  empList.onload = function() {
    empData = (this.responseText).split("<newrecord>");
    for (i = 0; i < empData.length - 1; i++) {
      each = empData[i].split("/");
      empDataObjects.push({
        id: each[0],
        f_name: each[1],
        l_name: each[2]
      });
    }
    persistent.push.apply(persistent, empDataObjects);
    loadEmployeeLists();
  }
  empList.open("get", "../php/get/get-emps.php", true);
  empList.send();
}

function clearEmployeeLists() {
  $('#employee-field, #employee-insert-field').empty();
}

function selectEmployee(empID) {
  findEmpToRemove = empDataObjects.find(obj => obj.id == empID);
  indexOfEmpToRemove = empDataObjects.indexOf(findEmpToRemove);
  selectedEmployees.push(empDataObjects[indexOfEmpToRemove]);
  empDataObjects.splice(indexOfEmpToRemove, 1);
  clearEmployeeLists();
  loadEmployeeLists();
}

function deselectEmployee(empID) {
  findEmpToRemove = selectedEmployees.find(obj => obj.id == empID);
  indexOfEmpToRemove = selectedEmployees.indexOf(findEmpToRemove);
  empDataObjects.push(selectedEmployees[indexOfEmpToRemove]);
  selectedEmployees.splice(indexOfEmpToRemove, 1);
  clearEmployeeLists();
  loadEmployeeLists();
}

function resetEmpLists() {
  setTimeout(function() {
    selectedEmployees = [];
    empDataObjects = [];
    empDataObjects.push.apply(empDataObjects, persistent);
    clearEmployeeLists();
    loadEmployeeLists();
    document.getElementById('initial-job-notes-field').value = "";
  }, 160);
}

function buildCalendar(date) {
  date.setMonth(month, 1);
  dayOfWeek = date.getDay();
  year = date.getFullYear();
  document.getElementById('initial-job-notes-field').value = "";
  getNumberOfDaysInMonth(month + 1, year);

  $('#nav-bar').append('<div class="month-and-arrows" id="forward" onclick="changeMonth(1);"><image src="../images/next.svg"></image></div><div class="month-and-arrows" id="month-displayed">' + months[month] + ' ' + year + '</div><div class="month-and-arrows" id="backward" onclick="changeMonth(-1);"><image src="../images/back.svg"</image></div>');
  for (i = 0; i < dayOfWeek; i++) {
    $('#calendar').append('<div class="empty-day"><p>&nbsp;</p></div>');
  }
  for (i = 1; i <= numberOfDaysInMonth; i++) {
    $('#calendar').append('<div class="day" id="' + i + '" onclick="openDailyAppointments('+ i +');"><p>' + i + '</p></div>');
  }

  // Changes the background color of the current day
  actualYear = todaysDate.getFullYear();
  actualMonth = todaysDate.getMonth();
  actualDay = todaysDate.getDate();
  if (year === actualYear && month === actualMonth) {
    $('#' + actualDay).addClass('today');
  }

  // For mobile devices, displays the day of the week next to the numerical day of the month
  for (i = 1; i <= numberOfDaysInMonth; i++) {
    date.setDate(i);
    DOW = date.getDay();
    $('#' + i).append('<h6>' + days[DOW] + '</h6>');
  }
}

function getNumberOfDaysInMonth(month, year) {
  numberOfDaysInMonth = new Date(year, month, 0).getDate();
}

function drawRedAlerts() {
  for (i = 1; i < jobsPerDayArray.length; i++) {
    if (jobsPerDayArray[i] > 0) {
      $('#' + i).append('<div class="red-alert">' + jobsPerDayArray[i] + '</div>');
    }
  }
}

function clearRedAlerts() {
  for (i = 0; i <= numberOfDaysInMonth; i++) {
    $('#' + i).children('.red-alert').remove();
  }
}