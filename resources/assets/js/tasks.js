(() => {
  /*
    [Feature]: 點兩下編輯文字！！
  */
  const FETCH = self.fetch;
  const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  const USER_NAME = $('#username').text();
  const headers = {
    Accept: 'application/json',
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': CSRF_TOKEN,
  };
  const transformToTaskRow = (content, id, done) => (
    `
      <div class="task-row ${done ? 'hidden' : ''}" id="${id}" data-done = "${done ? 'true' : 'false'}">
      <input type="checkbox" name="" data-id="${id}" class="checkbox" ${done ? 'checked' : ''}>
      <p class="task-description">${content}</p>
      <button data-id="${id}" class="btn-delete-task">del</button>
      </div>
    `
  );

  if (FETCH) {
    fetch(`/${USER_NAME}/tasks/read`, {
      headers,
      method: 'GET',
    })
      .then(response => response.json())
      .then((taskList) => {
        initDataList(taskList);
        initFormFunction();
        setTaskRawFunction();
      });
    console.log('Fetch!');
  } else {
    // Use ajax.
    $.ajaxSetup({
      headers,
    });
    $.get(`/${USER_NAME}/tasks/read`, (response) => {
      const taskList = response;
      initDataList(taskList);
      initFormFunction();
      setTaskRawFunction();
    });
    console.log('No Fetch!');
  }

  function initDataList(taskList) {
    taskList.forEach((task, index) => {
      const content = task.content;
      const id = task.id;
      const done = task.is_done;
      insertToContainer(content, id, done);
    });
  }

  function initFormFunction() {
    $('.input-task').keypress(function(event) {
      let keycode = event.keyCode ? event.keyCode : event.which;
      if (keycode === 13) {
        const content = $(this).val();
        createTask(content, newId => insertToContainer(content, newId));
        $(this).val('');
      }
    });

    $('#with-done').on('click', function() {
      $('[data-done="true"]').toggleClass('hidden');
    });

    function slideToNewTask(newId) {
      $('html, body').animate({
        scrollTop: $(`.task-row#${newId}`).offset().top,
      }, 500, 'swing');
    }
  }

  function setTaskRawFunction() {
    $('.task-container').on('click', '.btn-delete-task', function() {
      const id = $(this).data('id');
      $(`.task-row#${id}`).hide();
      deleteTask(id);
    });

    $('.task-container').on('click', '.checkbox', function() {
      const taskId = $(this).data('id');
      const $taskRow = $(`.task-row#${taskId}`);
      const checked = $(this).prop('checked');
      const data = {
        is_done: checked,
      };
      if (checked) {
        const withDoneStatus = $('#with-done').prop('checked');
        slideRightAnimation($taskRow, withDoneStatus);
      } else {
        $taskRow.attr('data-done', 'false');
      }
      updateTask(data, taskId);
    });

    function slideRightAnimation($taskRow, withDoneStatus) {
      $taskRow.animate(
        {
          left: '300%',
          opacity: '-10',
        },
        700,
        'swing',
        () => {
          if (!withDoneStatus) $taskRow.addClass('hidden');
          $taskRow.attr('data-done', 'true');
          $taskRow.css({
            left: 0,
            opacity: 1,
          });
        },
      );
    }
  }

  function insertToContainer(content, id, done = false) {
    $('.task-container').prepend(transformToTaskRow(content, id, done));
  }

  function createTask(content, cb) {
    const stringfyData = JSON.stringify({
      content,
    });

    if (FETCH) {
      fetch(`/${USER_NAME}/tasks`, {
        headers,
        method: 'POST',
        body: stringfyData,
        credentials: 'include', // cookie
      })
        .then(response => response.json())
        .then(data => cb(data.id));
    } else {
      $.ajax({
        url: `/${USER_NAME}/tasks`,
        type: 'POST',
        data: stringfyData,
        success: response => cb(response.id),
      });
    }
  }

  function deleteTask(taskId) {
    if (FETCH) {
      fetch(`/${USER_NAME}/tasks/${taskId}`, {
        headers,
        method: 'DELETE',
        credentials: 'include', // cookie
      })
        .then(response => response.text())
        .then(response =>
          console.log(
            `The task ${taskId} deleted ? : ${response}`,
          ),
        );
    } else {
      $.ajax({
        url: `/${USER_NAME}/tasks/${taskId}`,
        type: 'DELETE',
        success: response =>
          console.log(
            `The task ${taskId} deleted ? : ${response}`,
          ),
      });
    }
  }

  function updateTask(data, taskId) {
    if (FETCH) {
      fetch(`/${USER_NAME}/tasks/${taskId}`, {
        headers,
        method: 'PUT',
        body: JSON.stringify(data),
        credentials: 'include', // cookie
      })
        .then(response => response.text())
        .then(status => console.log(`Update: ${status}`));
    } else {
      $.ajax({
        url: `/${USER_NAME}/tasks/${taskId}`,
        type: 'PUT',
        data: JSON.stringify(data),
        success: status => console.log(`Update: ${status}`),
      });
    }
  }
})();
