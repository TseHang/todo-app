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
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  var transformToTaskRow = function transformToTaskRow(content, id) {
    return '\n        <div class="task-row" id="' + id + '">\n        <input type="checkbox" name="" data-id="' + id + '" class="checkbox">\n        <p class="task-description">' + content + '</p>\n        <button data-id="' + id + '" class="btn-delete-task">del</button>\n        </div>\n        ';
  };
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  // $.get('http://tsehang.todolist.simpleinfo.tw/task', response => {
  //   const taskList = response;
  //   initDataList(taskList);
  //   setFunction();
  // });
  // TODO: 改成 if self.fetch ..... 記得加header
  fetch('http://tsehang.todolist.simpleinfo.tw/task').then(function (response) {
    return response.json();
  }).then(function (taskList) {
    initDataList(taskList);
    setFunction();
  });

  function initDataList(taskList) {
    for (var i = 0; i < taskList.length; i++) {
      var content = taskList[i].content;
      var id = taskList[i].id;
      insertNewTask(content, id);
    }
  }

  function setFunction() {
    $('.input-task').keypress(function (event) {
      var keycode = event.keyCode ? event.keyCode : event.which;
      if (keycode === 13) {
        var content = $(this).val();
        createTask(content, function (newId) {
          insertNewTask(content, newId);
          $('html, body').animate({
            scrollTop: $('.task-row#' + newId).offset().top
          }, 500, 'swing');
        });
        $(this).val('');
      }
    });

    $('.btn-delete-task').on('click', function () {
      var id = $(this).data('id');
      clearDeleteTask(id);
    });

    $('.checkbox').on('click', function () {
      var taskId = $(this).data('id');
      var taskRow = $('.task-row#' + taskId);
      taskRow.toggleClass('checked');
      if ($(this).prop('checked')) {
        taskRow.animate({
          left: '300%',
          opacity: '0'
        }, 500, function () {
          taskRow.hide();
        });
      }
    });
  }

  function insertNewTask(content, id) {
    $('.task-container').append(transformToTaskRow(content, id));
  }
  function clearDeleteTask(id) {
    $('.task-row#' + id).hide();
    deleteTask(id);
  }

  function createTask(content, cb) {
    $.ajax({
      url: '/tasks',
      type: 'POST',
      data: {
        content: content
      },
      dataType: 'json',
      success: function success(response) {
        console.log(response);
        // cb(response.id)
      }
    });
  }

  function deleteTask(id) {
    $.post('http://tsehang.todolist.simpleinfo.tw/task/' + id + '/delete', function (response, status) {
      console.log('Data: ' + response + '\nStatus: ' + status);
    });
  }
})();

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);