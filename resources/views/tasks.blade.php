@extends('layout')

@section('title', '| Home')

@section('style')
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 10vh;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(123, 123, 123, 0.4);
        }

        .modal-content {
            background-color: #222222;
            margin: auto;
            padding: 1vh;
            border: 1px solid #000000;
            width: 100vh;
        }

        .modal-content > .text-task {
            max-height: 50vh;
            overflow: auto;
        }

        .modal-content > input {
            background-color: black;
        }

        .modal-content > .datetime-task {
            width: 30vh;
            font-size: 2vh;
            text-align: center;
        }

        .modal-content > #OnCreateTask {
            width: 40vh;
        }

        .close {
            margin-top: -1vh;
            color: #aaaaaa;
            float: right;
            font-size: 3vh;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #ffffff;
            text-decoration: none;
            cursor: pointer;
        }

        .DivTask {
            border: 0.3vh solid #ffffff;
            margin: 1vh;
        }

        .DivDateTime {
            text-align: center;
            font-size: 3vh;
            font-weight: bold;
            border-bottom: 0.1vh solid #ffffff;
        }

        .DivText {
            word-wrap: break-word;
            padding: 1vh;
        }

        #ButtonNewTask, #ButtonLogout {
            background-color: #222222;
            font-size: 5vh;
            text-align: center;
            margin: 1vh;
            border: 0.1vh solid #ffffff;
        }

        #ButtonNewTask { width: 110vh;}
        #ButtonLogout { width: 59.7vh;}

        .text-task {
            border: 0.1vh solid #ffffff;
            min-height: 5vh;
            padding: 0.5vh;
        }

        .datetime-task {
            margin-top: 1vh;
            border: none;
        }

        #OnCreateTask, #OnSaveTask, #OnRemoveTask {
            margin-top: 1vh;
            font-size: 2vh;
        }
    </style>
@endsection

@section('body')
        <input id="ButtonNewTask" type="button" value="New task scheduler">
        <input id="ButtonLogout" type="button" value="Logout">
    <div id="ModalDialogOnCreate" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="text-task" contenteditable="true"></div>
            <input id="DateTimeTask" class="datetime-task" type="datetime-local">
            <input id="OnCreateTask" type="button" value="Create task">
        </div>
    </div>

    <div id="Tasks">
        <?php
        //@foreach($tasks as $task)
        foreach ($tasks as $task)
        {
            echo "<div class='DivTask'>
                    <input type='hidden' value='$task->Id' class='Id'>
                    <div class='DivDateTime'>".date("M d, Y g:i A", strtotime($task->ReminderDate))."</div>
                    <div class='DivText'>$task->Task</div>
                  </div>";
        }
        //@endforeach
        ?>
    </div>
    <div id="ModalDialogOnEdiDel" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <input type="hidden" Id="Id" value="">
            <div id="Task" class="text-task" contenteditable="true"></div>
            <input id="Datetime" class="datetime-task" type="datetime-local">
            <input id="OnSaveTask" type="button" value="Save task">
            <input id="OnRemoveTask" type="button" value="Remove task">
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#ButtonNewTask').click(function () {
                $('#ModalDialogOnCreate').css('display', 'block');
            });

            $('.close').click(function () {
                $('#ModalDialogOnCreate').css('display', 'none');
                $('#ModalDialogOnEdiDel').css('display', 'none');
                $('.datetime-task').val('');
                $('.text-task').html('');
            });

            $(window).click(function () {
                if (event.target == $('#ModalDialogOnCreate')) {
                    $('#ModalDialogOnCreate').css('display', 'none');
                }
            });

            $('#OnCreateTask').click(function () {
                $.post('/NewTask', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    Task: $('.text-task').html(),
                    ReminderDate: $('.datetime-task').val()
                }).done(function (data) {
                    // if (JSON.parse(data) != null) {
                    // var d = JSON.parse(data);
                    // $('#ModalDialog').css('display', 'none');
                    // $('#TextTask').html('');
                    // $('#DateTimeTask').val('');
                    //
                    // $("#Tasks").html("");
                    // for (var i = 0; i < d.length; i++) {
                    //     var DivTask = document.createElement("div");
                    //     var DivDateTime = document.createElement("div");
                    //     var DivText = document.createElement("div");
                    //
                    //     $(DivText).html(d[i].Task);
                    //     $(DivText).addClass("DivText");
                    //     $(DivDateTime).html(d[i].ReminderDate);
                    //     $(DivDateTime).addClass("DivDateTime");
                    //
                    //     $(DivTask).addClass("DivTask");
                    //     $(DivTask).append(DivDateTime, DivText);
                    //
                    //     $("#Tasks").append(DivTask, "<hr/>");
                    // }
                    window.location = "/";
                    // }
                });
            });

            $(".DivTask").click(function () {
                var d = new Date($(this).find(".DivDateTime").html());//.toISOString();
                d.setHours(d.getHours() + 2);
                var sdata = d.toISOString();

                $('#ModalDialogOnEdiDel').css('display', 'block');
                $('#Id').val($(this).find(".Id").val())
                $('.datetime-task').val(sdata.substring(0, sdata.length-1));
                $('.text-task').html($(this).find(".DivText").html());
            });

            $('#OnSaveTask').click(function () {
                $.post('/EditTask', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    Id: $("#Id").val(),
                    Task: $('#Task').html(),
                    ReminderDate: $('#Datetime').val()
                }).done(function (data) {
                    window.location = "/";
                });
            });

            $('#OnRemoveTask').click(function () {
                $.post('/DeleteTask', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    Id: $("#Id").val(), Task: $('#Task').html(),
                    ReminderDate: $('#Datetime').val()
                }).done(function (data) {
                    window.location = "/";
                });
            });

            $('#ButtonLogout').click(function () {
                $.get('/Logout', {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }).done(function (data) {
                    window.location = "/";
                });
            });
        });
    </script>
@endsection