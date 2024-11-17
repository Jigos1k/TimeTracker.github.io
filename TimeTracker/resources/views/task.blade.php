@extends('layout.app')

@section('content')
    <style>
        .item:not(.active){
            background-color: none !important; 
            color: var(--bs-secondary);
        }
        .item.active, .item:hover{
            background-color: var(--bs-primary-bg-subtle); 
            color: var(--bs-primary);
        }
        .btn.btn-light.primary:hover{
            background-color: var(--bs-primary-bg-subtle);
        }
        .btn.btn-light.secondary:hover{
            background-color: var(--bs-secondary-bg-subtle)
        }
        #taskPanel.show {
            bottom: 0 !important;
        }
        #taskPanel{
            display: none; 
            position: fixed; 
            bottom: -100px;
            left: 0;
            transition: bottom 0.5s ease;
        }
        .date-button.active{
            background-color: var(--bs-primary);
            color: var(--bs-white) !important;
        }
    </style>
    {{-- <div class="form-control p-1 mb-2 shadow-sm border-0">
        <div class="bg-body-secondary d-flex align-items-center rounded-2 shadow-sm border mb-2">
            <div class="form-control w-auto m-1 py-1 px-2">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <input class="form-control-plaintext" placeholder="Найти">
        </div>
        <div class="row">
            <div class="col pe-1">
                <button class="btn btn-light primary text-primary form-control border-0 d-flex justify-content-center">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-chart-line fs-5"></i>
                        <div class="ms-2">Статистика</div>
                    </div>
                </button>
            </div>
            <div class="col-auto px-0">
                <div class="d-flex align-items-center h-100">
                    <div class="vr border-2 my-1 border-secondary-subtle"></div>
                </div>
            </div>
            <div class="col ps-1">
                <button class="btn btn-primary form-control border-0 d-flex justify-content-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-plus fs-5"></i>
                        <div class="ms-2">Задание</div>
                    </div>
                </button>
            </div>
        </div>
    </div> --}}
    <button class="btn btn-primary form-control border-0 d-flex justify-content-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-plus fs-5"></i>
            <div class="ms-2">Задание</div>
        </div>
    </button>
    <div class="d-flex align-items-center my-3 rounded-5 bg-secondary-subtle p-1">
        <div class="w-100 text-center"><span id="currentMonth"></span></div>
    </div>
    <div class="d-flex align-items-center my-3">
        <div class="me-1">
            <div class="h-100 d-flex align-items-center">
                <button class="btn btn-light primary rounded-circle p-1 border-0 text-primary h-100" id="prevButton">
                    <i class="fa-solid fa-angle-left d-flex align-items-center justify-content-center fs-5" style="width: 15px; height: 15px;"></i>
                </button>
            </div>
        </div>
        <div class="w-100"  style="max-width: 100%; overflow: hidden;">
            <button class="btn form-control w-auto mx-1 px-0 border-0 date-button d-none date-button-original" data-target="" data-month="">
                <div style="width: 55px">
                    <div class="text-center fs-6 dateofweek"></div>
                    <div class="text-center fw-bolder fs-5 day"></div>
                </div>
            </button>
            <div class="d-flex align-items-center p-1 date-carousel">
                @foreach($tasks as $index => $day)
                    <button class="btn form-control w-auto mx-1 px-0 border-0 date-button {{ $index == 0 ? 'active' : '' }}" data-target="{{$day['date']}}" data-month="{{$day['month']}}">
                        <div style="width: 55px">
                            <div class="text-center fs-6">{{$day['dateofweek']}}</div>
                            <div class="text-center fw-bolder fs-5">{{$day['day']}}</div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
        <div class="ms-1">
            <div class="h-100 d-flex align-items-center">
                <button class="btn btn-light primary rounded-circle p-1 border-0 text-primary h-100" id="nextButton">
                    <i class="fa-solid fa-angle-right d-flex align-items-center justify-content-center fs-5" style="width: 15px; height: 15px;"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 panel w-100 mx-2 mb-5 content-div content-div-empty-original d-none" id="">
        <div class="card-header bg-body-secondary border-0">
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center h-100">
                        <div class="">
                            <span class="fw-semibold fullweek"></span> <span class="fs-medium text-body-tertiary fulldate"></span>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-light primary text-primary border-0">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-square-pen fs-5"></i>
                            <div class="ms-2">Добавить</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item p-2">
                <div class="form-control border-2 border-primary bg-primary-subtle rounded-3">
                    <div class="d-flex align-items-center mb-2  text-primary">
                        <i class="fa-regular fa-calendar-xmark fs-4"></i>
                        <div class="ms-2 fw-semibold">Сегодня у вас нет задач!</div>
                    </div>
                    <div>Можно немного расслабиться.</div>
                    <div>Если что-то появится, дайте знать!</div>
                </div>
            </li>
        </ul>
    </div>

    <div class="card shadow border-0 panel w-100 mx-2 mb-5 content-div content-div-original d-none" id="">
        <div class="card-header bg-body-secondary border-0">
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center h-100">
                        <div class="">
                            <span class="fw-semibold fullweek"></span> <span class="fs-medium text-body-tertiary fulldate"></span>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-light primary text-primary border-0">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-square-pen fs-5"></i>
                            <div class="ms-2">Добавить</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item p-2 original d-none">
                <div class="row">
                    <div class="col-auto pe-0">
                        <div class="d-flex align-items-center h-100">
                            <input class="form-check-input mt-0 d-none" type="checkbox" id="task" name="task[][id]" form="form_access" value="" aria-label="Checkbox for following text input" style="width: 20px; height: 20px;" data-status="0">
                            <input class="form-check-input mt-0 bg-success border-success d-none" type="checkbox" id="task" name="task[][id]" form="form_access" value="" aria-label="Checkbox for following text input" style="width: 20px; height: 20px;" checked disabled data-status="1">                       
                            <input class="form-check-input mt-0 bg-danger border-danger d-none" type="checkbox" id="task" name="task[][id]" form="form_access" value="" aria-label="Checkbox for following text input" style="width: 20px; height: 20px;" checked disabled data-status="2">                       
                        </div>
                    </div>
                    <div class="col">
                        <div class="h-100">
                            <div class="fw-semibold text-nowrap" data-target="name"></div>   
                            <div class="fs-6 text-body-tertiary">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-clock"></i>
                                    <div class="ms-1" data-target="time"></div>
                                </div>
                            </div>               
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center h-100">
                                <div class="form-control bg-secondary-subtle border-2 border-secondary py-1 d-flex justify-content-center d-none" data-status="0">
                                    <div class="d-flex align-items-center text-secondary">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <div class="ms-2 fw-bolder">В процессе</div>
                                    </div>
                                </div>
                                <div class="form-control bg-success-subtle border-2 border-success py-1 d-flex justify-content-center d-none" data-status="1">
                                    <div class="d-flex align-items-center text-success">
                                        <i class="fa-regular fa-circle-check fs-5"></i>
                                        <div class="ms-2 fw-bolder">Выполнено</div>
                                    </div>
                                </div>
                                <div class="form-control bg-danger-subtle border-2 border-danger py-1 d-flex justify-content-center d-none" data-status="2">
                                    <div class="d-flex align-items-center text-danger">
                                        <i class="fa-regular fa-circle-xmark fs-5"></i>
                                        <div class="ms-2 fw-bolder">Отменено</div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-light primary text-primary border-0 h-100">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-gear fs-5"></i>
                            </div>
                        </button>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="d-flex content-divs" style="max-width: 100%; overflow: auto;">
        @foreach($tasks as $index => $day)
            <div class="card shadow border-0 panel w-100 mx-2 mb-5 content-div {{ $index > 0 ? 'd-none' : '' }}" id="{{$day['date']}}">
                <div class="card-header bg-body-secondary border-0">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex align-items-center h-100">
                                <div class="">
                                    <span class="fw-semibold">{{$day['fullweek']}}</span> <span class="fs-medium text-body-tertiary">{{$day['fulldate']}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-light primary text-primary border-0">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-square-pen fs-5"></i>
                                    <div class="ms-2">Добавить</div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    @if (empty($day['task']))
                        <li class="list-group-item p-2">
                            <div class="form-control border-2 border-primary bg-primary-subtle rounded-3">
                                <div class="d-flex align-items-center mb-2  text-primary">
                                    <i class="fa-regular fa-calendar-xmark fs-4"></i>
                                    <div class="ms-2 fw-semibold">Сегодня у вас нет задач!</div>
                                </div>
                                <div>Можно немного расслабиться.</div>
                                <div>Если что-то появится, дайте знать!</div>
                            </div>
                        </li>
                    @else
                        @foreach ($day['task'] as $task)
                            <li class="list-group-item p-2">
                                <div class="row">
                                    <div class="col-auto pe-0">
                                        <div class="d-flex align-items-center h-100">
                                            <input class="form-check-input mt-0 @if ($task->status_id == 1) bg-success border-success @endif @if ($task->status_id == 2) bg-danger border-danger @endif" type="checkbox" id="task" name="task[][id]" form="form_access" value="{{$task->id}}" aria-label="Checkbox for following text input" style="width: 20px; height: 20px;" @if ($task->status_id != 0)checked disabled @endif>                       
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="h-100">
                                            <div class="fw-semibold text-nowrap">{{$task->name}}</div>   
                                            <div class="fs-6 text-body-tertiary">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-regular fa-clock"></i>
                                                    <div class="ms-1">{{ \Carbon\Carbon::parse($task->time)->format('H:i') }}</div>
                                                </div>
                                            </div>               
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-center h-100">
                                            @if ($task->status_id == 0)
                                                <div class="form-control bg-secondary-subtle border-2 border-secondary py-1 d-flex justify-content-center">
                                                    <div class="d-flex align-items-center text-secondary">
                                                        <div class="spinner-border spinner-border-sm" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        <div class="ms-2 fw-bolder">В процессе</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($task->status_id == 1)
                                                <div class="form-control bg-success-subtle border-2 border-success py-1 d-flex justify-content-center">
                                                    <div class="d-flex align-items-center text-success">
                                                        <i class="fa-regular fa-circle-check fs-5"></i>
                                                        <div class="ms-2 fw-bolder">Выполнено</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($task->status_id == 2)
                                                <div class="form-control bg-danger-subtle border-2 border-danger py-1 d-flex justify-content-center">
                                                    <div class="d-flex align-items-center text-danger">
                                                        <i class="fa-regular fa-circle-xmark fs-5"></i>
                                                        <div class="ms-2 fw-bolder">Отменено</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-light primary text-primary border-0 h-100">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-gear fs-5"></i>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        @endforeach
    </div>
    <div id="taskPanel" class="form-control rounded-top-4 rounded-bottom-0 border-0 pb-5 pt-4">
        <form action="{{ route('task.access') }}" method="POST" name="form_access" id="form_access">
            @csrf
        </form>
        <div class="row">
            <div class="col">
                <button class="btn btn-outline-danger form-control fw-bolder" type="submit" name="mode" value="2" form="form_access">
                    Отменить
                </button>
            </div>
            <div class="col">
                <button class="btn btn-success form-control fw-bolder" type="submit" name="mode" value="1" form="form_access">
                    Выполнено
                </button>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-bottom rounded-top-4 h-auto" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header py-0">
            <button type="button" class="btn border-0 w-100 text-center" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-minus fs-2 text-secondary"></i></button>
        </div>
        <div class="offcanvas-body pb-5 pt-2">
            <form action="{{ route('task.create') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="task_name" id="task_name" placeholder="">
                    <label for="task_name">Название задачи</label>
                  </div>
                <div class="form-floating mb-3">
                    <textarea type="text" class="form-control" name="task_comment" id="task_comment" placeholder=""></textarea>
                    <label for="task_comment">Описание</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" name="task_date" id="task_date" placeholder="">
                    <label for="task_date">Дата</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="time" class="form-control" name="task_time" id="task_time" placeholder="">
                    <label for="task_time">Время</label>
                </div>
                <button type="submit" class="btn btn-primary form-control">Создать</button>
            </form>
        </div>
    </div>
    <script>
       document.addEventListener("DOMContentLoaded", function() {
            let checkboxes = document.querySelectorAll('#task');
            const taskPanel = document.getElementById('taskPanel');
            const datecarousel = document.querySelector('.date-carousel');
            let buttons = datecarousel.querySelectorAll('.date-button');
            const contentDivsContainer = document.querySelector('.content-divs');
            let contentDivs = contentDivsContainer.querySelectorAll('.content-div');
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const currentMonthDisplay = document.getElementById('currentMonth');
            let currentIndex = 0;
            let activeIndex = 0;
            
            function updateContent(index) {
                contentDivs.forEach(div => div.classList.add('d-none'));
                contentDivs[index].classList.remove('d-none');
                currentMonthDisplay.textContent = buttons[index].getAttribute('data-month');

                if (index >= buttons.length - 4) {
                    loadMoreDates(buttons[buttons.length - 1].getAttribute('data-target'));
                }
            }

            function updateActiveButton(index) {
                buttons.forEach((button, i) => {
                    if (i === index) {
                        button.classList.add('active');
                        button.scrollIntoView({ behavior: "smooth", inline: "center" });
                    } else {
                        button.classList.remove('active');
                    }
                });
            }

            function loadMoreDates(currentDate) {
                
                fetch('/get-dates?current_date=' + currentDate)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(dateObj => {
                            addNewDateButton(dateObj);
                            checkboxes = document.querySelectorAll('#task');
                        });
                    });
            }

            function addNewDateButton(dateObj) {
                
                const originalDivDate = document.querySelector(".date-button-original");
    
                if (originalDivDate) {
                    const clonedDiv = originalDivDate.cloneNode(true);

                    const dateofweekElement = clonedDiv.querySelector(".dateofweek");
                    const dayElement = clonedDiv.querySelector(".day");

                    if (dateofweekElement) dateofweekElement.textContent = dateObj.dateofweek;
                    if (dayElement) dayElement.textContent = dateObj.day;

                    clonedDiv.setAttribute("data-target", dateObj.date);
                    clonedDiv.setAttribute("data-month", dateObj.month);
                    clonedDiv.classList.remove("date-button-original");
                    clonedDiv.classList.remove("d-none");
                    
                    document.querySelector(".date-carousel").appendChild(clonedDiv);
                    buttons = datecarousel.querySelectorAll('.date-button');
                }
                if(JSON.parse(dateObj.task).length != 0){
                    const originalDivPanel = document.querySelector(".content-div-original");
                    if (originalDivPanel) {
                        const clonedDiv = originalDivPanel.cloneNode(true);
                        clonedDiv.id = dateObj.date;

                        const fullweek = clonedDiv.querySelector(".fullweek");
                        const fulldate = clonedDiv.querySelector(".fulldate");

                        if (fullweek) fullweek.textContent = dateObj.fullweek;
                        if (fulldate) fulldate.textContent = dateObj.fulldate;

                        JSON.parse(dateObj.task).forEach(index => {
                            const listGroup = document.querySelector(".list-group .list-group-item.original");
                            
                            const clonedlistItem = listGroup.cloneNode(true);
                            
                            const elements = clonedlistItem.querySelectorAll('[data-status="' + index.status_id +'"]');

                            elements.forEach((element) => {
                                element.classList.remove('d-none');
                            });

                            clonedlistItem.querySelectorAll('.form-check-input').forEach((element) => {
                                element.value = index.id;
                            });
                            clonedlistItem.querySelector('[data-target="name"]').textContent = index.name;
                            clonedlistItem.querySelector('[data-target="time"]').textContent = index.time;
                            clonedlistItem.classList.remove("original");
                            clonedlistItem.classList.remove("d-none");

                            clonedDiv.querySelector("ul.list-group").appendChild(clonedlistItem);
                        });

                        clonedDiv.classList.remove("content-div-original");
                        
                        document.querySelector(".content-divs").appendChild(clonedDiv);
                        contentDivs = contentDivsContainer.querySelectorAll('.content-div');
                    }
                }else{
                    const originalDivPanel = document.querySelector(".content-div-empty-original");
                    if (originalDivPanel) {
                        originalDivPanel.id = dateObj.date;
                        const clonedDiv = originalDivPanel.cloneNode(true);

                        const fullweek = clonedDiv.querySelector(".fullweek");
                        const fulldate = clonedDiv.querySelector(".fulldate");

                        if (fullweek) fullweek.textContent = dateObj.fullweek;
                        if (fulldate) fulldate.textContent = dateObj.fulldate;

                        clonedDiv.classList.remove("content-div-empty-original");
                        
                        document.querySelector(".content-divs").appendChild(clonedDiv);
                        contentDivs = contentDivsContainer.querySelectorAll('.content-div');
                    }
                }
            }

            buttons.forEach((button, index) => {
                button.addEventListener('click', () => {
                    currentIndex = index;
                    updateContent(currentIndex);
                    updateActiveButton(currentIndex);
                });
            });

            prevButton.addEventListener('click', () => {
                currentIndex = currentIndex > 0 ? currentIndex - 1 : 0;
                updateContent(currentIndex);
                updateActiveButton(currentIndex);
            });

            nextButton.addEventListener('click', () => {
                currentIndex = currentIndex < buttons.length - 1 ? currentIndex + 1 : buttons.length - 1;
                updateContent(currentIndex);
                updateActiveButton(currentIndex);
            });

            updateContent(currentIndex);
            updateActiveButton(currentIndex);

            
            const togglePanel = () => {
                const isAnyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked && !checkbox.disabled);

                if (isAnyChecked) {
                    taskPanel.style.display = 'block';
                    setTimeout(() => {
                        taskPanel.classList.add('show');
                    }, 10);
                } else {
                    taskPanel.classList.remove('show');
                    setTimeout(() => {
                        taskPanel.style.display = 'none';
                    }, 500);
                }
            };

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', togglePanel);
            });

            togglePanel();
        });

        document.addEventListener('DOMContentLoaded', () => {
            
        });
    </script>
@endsection