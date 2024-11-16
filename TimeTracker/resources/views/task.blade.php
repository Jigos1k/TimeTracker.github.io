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
    </style>
    <div class="form-control p-1 mb-2 shadow-sm border-0">
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
    </div>
    {{-- <div class="form-control p-1 border-2 rounded-3 mb-2">
        <div class="row d-flex justify-content-center">
            <div class="col">
                <button class="active item form-control px-2 border-0 d-flex justify-content-center" id="Today">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-calendar-day fs-5"></i>
                        <div class="ms-2 fw-medium">День</div>
                    </div>
                </button>
            </div>
            <div class="col p-0">
                <button class="item form-control px-2 border-0 d-flex justify-content-center" id="Week">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-calendar-week fs-5"></i>
                        <div class="ms-2 fw-medium">Неделя</div>
                    </div>
                </button>
            </div>
            <div class="col">
                <button class="item form-control px-2 border-0 d-flex justify-content-center" id="Week">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-calendar-days fs-5"></i>
                        <div class="ms-2 fw-medium">Месяц</div>
                    </div>
                </button>
            </div>
        </div>
    </div> --}}
    @foreach($tasks as $day)
        <div class="card shadow border-0 panel mb-2">
            <div class="card-header bg-body-secondary border-0">
                <div class="row">
                    <div class="col">
                        <div class="d-flex align-items-center h-100">
                            <div class="">
                                <span class="fw-semibold">{{$day['dateofweek']}}</span> <span class="fs-medium text-body-tertiary">{{$day['date']}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-light primary text-primary border-0">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-square-pen fs-5"></i>
                                <div class="ms-2">Редактировать</div>
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
                                        <div class="fw-semibold">{{$task->name}}</div>   
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
    <section class="d-flex justify-content-center">
        <div>
            <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </section>
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
        // Находим секцию
        const section = document.querySelector('section');

        // Создаем функцию для обработки пересечений
        const observerCallback = (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    console.log('The section is now visible on the screen!');
                } else {
                    console.log('The section is no longer visible on the screen.');
                }
            });
        };

        // Настройки для IntersectionObserver
        const observerOptions = {
            root: null, // Отслеживать относительно viewport
            threshold: 0.5 // Процент видимости (50%)
        };

        // Создаем наблюдатель
        const observer = new IntersectionObserver(observerCallback, observerOptions);

        // Начинаем наблюдение за секцией
        observer.observe(section);

        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('#task');
            const taskPanel = document.getElementById('taskPanel');

            // Функция для проверки состояния чекбоксов
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
    </script>
@endsection