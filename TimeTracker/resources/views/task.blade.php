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
    </style>
    <div class="form-control p-1 mb-2 border-2">
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
                <button class="btn btn-primary form-control border-0 d-flex justify-content-center">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-plus fs-5"></i>
                        <div class="ms-2">Задание</div>
                    </div>
                </button>
            </div>
        </div>
    </div>
    <div class="form-control p-1 border-2 rounded-3 mb-2">
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
    </div>
    <div class="card border-2">
        <div class="card-header bg-body-secondary">
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center h-100">
                        <div class="">
                            <span class="fw-semibold">Сегодня,</span><span class="fs-medium text-body-tertiary"> 13 нояб.</span>
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
            <li class="list-group-item">
                <div class="row">
                    <div class="col-auto pe-0">
                        <div class="d-flex align-items-center h-100">
                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" style="width: 20px; height: 20px;">                       
                        </div>
                    </div>
                    <div class="col">
                        <div class="h-100">
                            <div class="fw-semibold">Название задачи</div>   
                            <div class="fs-6 text-body-tertiary">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-clock"></i>
                                    <div class="ms-1">21:35</div>
                                </div>
                            </div>               
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center h-100">
                            <div class="badge text-bg-success rounded-5 py-1 w-100 d-flex justify-content-center">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-circle-check text-white fs-5"></i>
                                    <div class="ms-2 fw-normal">Выполнено</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-auto pe-0">
                        <div class="d-flex align-items-center h-100">
                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" style="width: 20px; height: 20px;">                       
                        </div>
                    </div>
                    <div class="col">
                        <div class="h-100">
                            <div class="fw-semibold">Название задачи</div>   
                            <div class="fs-6 text-body-tertiary">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-clock"></i>
                                    <div class="ms-1">21:35</div>
                                </div>
                            </div>               
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center h-100">
                            <div class="badge text-bg-warning rounded-5 py-1 w-100 d-flex justify-content-center">
                                <div class="d-flex align-items-center">
                                    <div class="spinner-border spinner-border-sm text-white" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="ms-2 fw-normal text-white">В процессе</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </li>
            <li class="list-group-item bg-secondary-subtle">
                <div class="row">
                    <div class="col-auto pe-0">
                        <div class="d-flex align-items-center h-100">
                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" style="width: 20px; height: 20px;">                       
                        </div>
                    </div>
                    <div class="col">
                        <div class="h-100">
                            <div class="fw-semibold">Название задачи</div>   
                            <div class="fs-6 text-body-tertiary">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-clock"></i>
                                    <div class="ms-1">21:35</div>
                                </div>
                            </div>               
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center h-100">
                            <div class="badge text-bg-secondary rounded-5 py-1 w-100 d-flex justify-content-center">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-circle-right fs-5"></i>
                                    <div class="ms-2 fw-normal text-white">Перенесено</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-auto pe-0">
                        <div class="d-flex align-items-center h-100">
                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" style="width: 20px; height: 20px;">                       
                        </div>
                    </div>
                    <div class="col">
                        <div class="h-100">
                            <div class="fw-semibold">Название задачи</div>   
                            <div class="fs-6 text-body-tertiary">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-clock"></i>
                                    <div class="ms-1">21:35</div>
                                </div>
                            </div>               
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center h-100">
                            <div class="badge text-bg-danger rounded-5 py-1 w-100 d-flex justify-content-center">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-xmark fs-5"></i>
                                    <div class="ms-2 fw-normal">Отменено</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </li>
        </ul>
    </div>
@endsection