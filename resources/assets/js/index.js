(() => {
  const transformToTaskRow = (content, id) => {
    return `
      <div class="task-row" id="${id}">
      <input type="checkbox" name="" data-id="${id}" class="checkbox">
      <p class="task-description">${content}</p>
      <button data-id="${id}" class="btn-delete-task">del</button>
      </div>
      `;
  };

  // $.get('http://tsehang.todolist.simpleinfo.tw/task', response => {
  //   const taskList = response;
  //   initDataList(taskList);
  //   setFunction();
  // });
  // TODO: 改成 if self.fetch ..... 記得加header
  fetch('http://tsehang.todolist.simpleinfo.tw/task')
    .then(response => response.json())
    .then(taskList => {
      initDataList(taskList);
      setFunction();
    });

  function initDataList(taskList) {
    for (let i = 0; i < taskList.length; i++) {
      const content = taskList[i].content;
      const id = taskList[i].id;
      insertNewTask(content, id);
    }
  }

  function setFunction() {
    $('.input-task').keypress(function(event) {
      let keycode = event.keyCode ? event.keyCode : event.which;
      if (keycode === 13) {
        const content = $(this).val();
        createTask(content, newId => {
          insertNewTask(content, newId);
          $('html, body').animate(
            {
              scrollTop: $(`.task-row#${newId}`).offset().top,
            },
            500,
            'swing'
          );
        });
        $(this).val('');
      }
    });

    $('.btn-delete-task').on('click', function() {
      const id = $(this).data('id');
      clearDeleteTask(id);
    });

    $('.checkbox').on('click', function() {
      const taskId = $(this).data('id');
      const taskRow = $(`.task-row#${taskId}`);
      taskRow.toggleClass('checked');
      if ($(this).prop('checked')) {
        taskRow.animate(
          {
            left: '300%',
            opacity: '0',
          },
          500,
          () => {
            taskRow.hide();
          }
        );
      }
    });
  }

  function insertNewTask(content, id) {
    $('.task-container').append(transformToTaskRow(content, id));
  }
  function clearDeleteTask(id) {
    $(`.task-row#${id}`).hide();
    deleteTask(id);
  }

  function createTask(content, cb) {
    $.post(
      'http://tsehang.todolist.simpleinfo.tw/task',
      { content },
      (response, status) => {
        cb(response.id);
      }
    );
  }

  function deleteTask(id) {
    $.post(
      `http://tsehang.todolist.simpleinfo.tw/task/${id}/delete`,
      (response, status) => {
        console.log(`Data: ${response}\nStatus: ${status}`);
      }
    );
  }
})();