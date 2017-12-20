/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

(function () {
  /*
    [Feature]: 點兩下編輯文字！！
  */
  var FETCH = self.fetch;
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  var USER_NAME = $('#username').text();
  var headers = {
    Accept: 'application/json',
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': CSRF_TOKEN
  };
  var transformToTaskRow = function transformToTaskRow(content, id, done) {
    return '\n      <div class="task-row ' + (done ? 'hidden' : '') + '" id="' + id + '" data-done = "' + (done ? 'true' : 'false') + '">\n      <input type="checkbox" name="" data-id="' + id + '" class="checkbox" ' + (done ? 'checked' : '') + '>\n      <p class="task-description">' + content + '</p>\n      <button data-id="' + id + '" class="btn-delete-task">del</button>\n      </div>\n    ';
  };

  if (FETCH) {
    fetch('/' + USER_NAME + '/tasks/read', {
      headers: headers,
      method: 'GET'
    }).then(function (response) {
      return response.json();
    }).then(function (taskList) {
      initDataList(taskList);
      initFormFunction();
      setTaskRawFunction();
    });
    console.log('Fetch!');
  } else {
    // Use ajax.
    $.ajaxSetup({
      headers: headers
    });
    $.get('/' + USER_NAME + '/tasks/read', function (response) {
      var taskList = response;
      initDataList(taskList);
      initFormFunction();
      setTaskRawFunction();
    });
    console.log('No Fetch!');
  }

  function initDataList(taskList) {
    taskList.forEach(function (task, index) {
      var content = task.content;
      var id = task.id;
      var done = task.is_done;
      insertToContainer(content, id, done);
    });
  }

  function initFormFunction() {
    $('.input-task').keypress(function (event) {
      var keycode = event.keyCode ? event.keyCode : event.which;
      if (keycode === 13) {
        var content = $(this).val();
        createTask(content, function (newId) {
          return insertToContainer(content, newId);
        });
        $(this).val('');
      }
    });

    $('#with-done').on('click', function () {
      $('[data-done="true"]').toggleClass('hidden');
    });

    function slideToNewTask(newId) {
      $('html, body').animate({
        scrollTop: $('.task-row#' + newId).offset().top
      }, 500, 'swing');
    }
  }

  function setTaskRawFunction() {
    $('.task-container').on('click', '.btn-delete-task', function () {
      var id = $(this).data('id');
      $('.task-row#' + id).hide();
      deleteTask(id);
    });

    $('.task-container').on('click', '.checkbox', function () {
      var taskId = $(this).data('id');
      var $taskRow = $('.task-row#' + taskId);
      var checked = $(this).prop('checked');
      var data = {
        is_done: checked
      };
      if (checked) {
        var withDoneStatus = $('#with-done').prop('checked');
        slideRightAnimation($taskRow, withDoneStatus);
      } else {
        $taskRow.attr('data-done', 'false');
      }
      updateTask(data, taskId);
    });

    function slideRightAnimation($taskRow, withDoneStatus) {
      $taskRow.animate({
        left: '300%',
        opacity: '-10'
      }, 700, 'swing', function () {
        if (!withDoneStatus) $taskRow.addClass('hidden');
        $taskRow.attr('data-done', 'true');
        $taskRow.css({
          left: 0,
          opacity: 1
        });
      });
    }
  }

  function insertToContainer(content, id) {
    var done = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

    $('.task-container').prepend(transformToTaskRow(content, id, done));
  }

  function createTask(content, cb) {
    var stringfyData = JSON.stringify({
      content: content
    });

    if (FETCH) {
      fetch('/' + USER_NAME + '/tasks', {
        headers: headers,
        method: 'POST',
        body: stringfyData,
        credentials: 'include' // cookie
      }).then(function (response) {
        return response.json();
      }).then(function (data) {
        return cb(data.id);
      });
    } else {
      $.ajax({
        url: '/' + USER_NAME + '/tasks',
        type: 'POST',
        data: stringfyData,
        success: function success(response) {
          return cb(response.id);
        }
      });
    }
  }

  function deleteTask(taskId) {
    if (FETCH) {
      fetch('/' + USER_NAME + '/tasks/' + taskId, {
        headers: headers,
        method: 'DELETE',
        credentials: 'include' // cookie
      }).then(function (response) {
        return response.text();
      }).then(function (response) {
        return console.log('The task ' + taskId + ' deleted ? : ' + response);
      });
    } else {
      $.ajax({
        url: '/' + USER_NAME + '/tasks/' + taskId,
        type: 'DELETE',
        success: function success(response) {
          return console.log('The task ' + taskId + ' deleted ? : ' + response);
        }
      });
    }
  }

  function updateTask(data, taskId) {
    if (FETCH) {
      fetch('/' + USER_NAME + '/tasks/' + taskId, {
        headers: headers,
        method: 'PUT',
        body: JSON.stringify(data),
        credentials: 'include' // cookie
      }).then(function (response) {
        return response.text();
      }).then(function (status) {
        return console.log('Update: ' + status);
      });
    } else {
      $.ajax({
        url: '/' + USER_NAME + '/tasks/' + taskId,
        type: 'PUT',
        data: JSON.stringify(data),
        success: function success(status) {
          return console.log('Update: ' + status);
        }
      });
    }
  }
})();

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);