@extends('layouts.nav2')

@section('content')
@if ($users->role_id == 1)
    <div class="container-fluid">
        <div class="row justify-content-center">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <h1 class="text-center m-2">{{ __('Matches') }}</h1>
            <a class="text-center m-2 popup-trigger" href="#" role="button" aria-expanded="false">
                <img src="{{ asset('storage/icon/filter.png') }}" style="width: 50px; height: 50px;">
            </a>
            <div class="popup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; justify-content: center; align-items: center;">
                <div class="card popup-content" style="background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.5); width: 50%; max-height: 40%; overflow: auto; position: relative;">
                    <form action="/home/filter" method="POST" style="text-align: center">
                        @csrf
                        <div class="input-group" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <p class="mt-3" style="font-weight: bold;">Select Section</p>
                            <select name="section_filter" style="width: 80%; margin-top: 10px; padding: 10px; border-radius: 5px; border: 1px solid #ccc;" id="section_filter" class="form-control" aria-label="Select Section">
                                <option value="" disabled selected>Choose Job Section</option>
                                @foreach ($sections as $s)
                                    @if ($s->fields_id == $freelancer->field_of_work)
                                        <option for="section_filter" value="{{$s->section}}">{{ $s->section }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <button class="btn btn-primary mt-4" style="width: 80%; padding: 10px; border-radius: 5px;" type="submit" id="button-addon2">Filter</button>
                        </div>
                    </form>
                    <button class="popup-close" style="position: absolute; top: 10px; right: 10px; padding: 5px 10px; background-color: #f1f1f1; border: none; cursor: pointer; border-radius: 5px;">&times;</button>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var popupTrigger = document.querySelector('.popup-trigger');
                    var popup = document.querySelector('.popup');
                    var popupClose = document.querySelector('.popup-close');

                    popupTrigger.addEventListener('click', function(event) {
                        event.preventDefault();
                        popup.style.display = 'flex';
                    });

                    popupClose.addEventListener('click', function() {
                        popup.style.display = 'none';
                    });

                    popup.addEventListener('click', function(event) {
                        if (event.target === popup) {
                            popup.style.display = 'none';
                        }
                    });
                });
            </script>
<div class="d-flex flex-row justify-content-evenly align-items-center">
    <div id="dislike-container">
        <ion-icon id="dislike" name="heart-dislike"></ion-icon>
    </div>
    <div id="swiper-container">
        <div id="swiper"></div>
    </div>
    <div id="like-container">
        <ion-icon id="like" name="heart"></ion-icon>
    </div>
</div>

<!-- Modal -->
<div id="jobModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form>
            <div class="form-group">
                <label for="modalEmployerName">Employer Name</label>
                <input type="text" id="modalEmployerName" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalEmployerType">Employer Type</label>
                <input type="text" id="modalEmployerType" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalProjectName">Project Name</label>
                <input type="text" id="modalProjectName" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalProjectField">Project Field</label>
                <input type="text" id="modalProjectField" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalProjectSection">Project Section</label>
                <input type="text" id="modalProjectSection" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalProjectType">Project Type</label>
                <input type="text" id="modalProjectType" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalProjectDescription">Project Description</label>
                <textarea id="modalProjectDescription" class="form-control" readonly></textarea>
            </div>
            <div class="form-group">
                <label for="modalSalary">Salary</label>
                <input type="text" id="modalSalary" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalProjectDeadline">Project Deadline</label>
                <input type="text" id="modalProjectDeadline" class="form-control" readonly>
            </div>
        </form>
    </div>
</div>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<style>
    @media(max-width: 450px){
        #swiper {
            height: 40vh;
            aspect-ratio: 2 / 3;
            perspective: 500px;
            perspective-origin: center 50%;
            transform-style: preserve-3d;
            position: relative;
        }

        .card {
            width: 100%;
            height: 100%;
            position: absolute;
            border-radius: 20px;
            overflow: hidden;
            transform: translateZ(calc(-30px * var(--i))) translateY(calc(-20px * var(--i))) rotate(calc(-4deg * var(--i)));
            filter: drop-shadow(2px 2px 20px rgba(0, 0, 0, 0.5));
            cursor: pointer;
            user-select: none;
            transition: transform 0.5s;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 50%;
        }

        .card-content {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 10px;
        }

        #like,
        #dislike {
            font-size: 5vh;
            border-radius: 50%;
            padding: 20px;
            position: relative;
            z-index: 1;
            animation-name: animation1;
            animation-duration: 1s;
            animation-timing-function: ease-in-out;
            animation-fill-mode: both;
            animation-play-state: paused;
        }

        #like.trigger,
        #dislike.trigger {
            animation-name: animation2;
        }

        #like {
            color: red;
            background-color: rgba(255, 255, 255, 0.5);
        }

        #dislike {
            color: #ccc;
            background-color: rgba(0, 0, 0, 0.5);
        }

        @keyframes animation1 {
            0%, 100% {
                opacity: 0.2;
            }
            50% {
                opacity: 1;
            }
        }

        @keyframes animation2 {
            0%, 100% {
                opacity: 0.2;
            }
            50% {
                opacity: 1;
            }
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    }
    @media(min-width: 450px){
        #swiper {
            height: 70vh;
            aspect-ratio: 2 / 3;
            perspective: 1000px;
            perspective-origin: center 50%;
            transform-style: preserve-3d;
            position: relative;
        }

        .card {
            width: 100%;
            height: 100%;
            position: absolute;
            border-radius: 20px;
            overflow: hidden;
            transform: translateZ(calc(-30px * var(--i))) translateY(calc(-20px * var(--i))) rotate(calc(-4deg * var(--i)));
            filter: drop-shadow(2px 2px 20px rgba(0, 0, 0, 0.5));
            cursor: pointer;
            user-select: none;
            transition: transform 0.5s;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 50%;
        }

        .card-content {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 10px;
        }

        #like,
        #dislike {
            font-size: 16vh;
            border-radius: 50%;
            padding: 20px;
            position: relative;
            z-index: 1;
            animation-name: animation1;
            animation-duration: 1s;
            animation-timing-function: ease-in-out;
            animation-fill-mode: both;
            animation-play-state: paused;
        }

        #like.trigger,
        #dislike.trigger {
            animation-name: animation2;
        }

        #like {
            color: red;
            background-color: rgba(255, 255, 255, 0.5);
        }

        #dislike {
            color: #ccc;
            background-color: rgba(0, 0, 0, 0.5);
        }

        @keyframes animation1 {
            0%, 100% {
                opacity: 0.2;
            }
            50% {
                opacity: 1;
            }
        }

        @keyframes animation2 {
            0%, 100% {
                opacity: 0.2;
            }
            50% {
                opacity: 1;
            }
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    }
</style>

<script>
    let swipeLimitReached = false; // Flag to track swipe limit

    class Card {
        constructor({ job, onDismiss, onLike, onDislike }) {
            this.job = job;
            this.onDismiss = onDismiss;
            this.onLike = onLike;
            this.onDislike = onDislike;
            this.#init();
        }

        #startPoint;
        #offsetX = 0;
        #offsetY = 0;

        #isTouchDevice = () => {
            return (('ontouchstart' in window) ||
                    (navigator.maxTouchPoints > 0) ||
                    (navigator.msMaxTouchPoints > 0));
        }

        #init = () => {
            //  console.log("Initializing card with job data:", this.job);
            const card = document.createElement('div');
            card.classList.add('card');

            const img = document.createElement('img');
            img.src = `/storage/img/${this.job.employer.employer_image_link}`;
            card.append(img);

            const content = document.createElement('div');
            content.classList.add('card-content');
            content.innerHTML = `
            <h5>${this.job.employer.employer_name} (${this.job.employer.employer_type})</h5>
            <p>Project Name: ${this.job.project_name}</p>
            <p>Field: ${this.job.field.fields_of_work}</p> <!-- Display project field name -->
            `;
            card.append(content);

            this.element = card;
            if (this.#isTouchDevice()) {
                this.#listenToTouchEvents();
            } else {
                this.#listenToMouseEvents();
            }
        }

        #showDetails = () => {
            document.getElementById('modalEmployerName').value = this.job.employer.employer_name;
            document.getElementById('modalEmployerType').value = this.job.employer.employer_type;
            document.getElementById('modalProjectName').value = this.job.project_name;
            document.getElementById('modalProjectField').value = this.job.field.fields_of_work;
            document.getElementById('modalProjectSection').value = this.job.section.section;
            document.getElementById('modalProjectType').value = this.job.project_type;
            document.getElementById('modalProjectDescription').value = this.job.project_description;
            document.getElementById('modalSalary').value = formatSalary(this.job.salary);
            document.getElementById('modalProjectDeadline').value = formatDate(this.job.project_deadline);
            document.getElementById('jobModal').style.display = 'block';
        }

        #listenToTouchEvents = () => {
            this.element.addEventListener('touchstart', (e) => {
                const touch = e.changedTouches[0];
                if (!touch) return;
                const { clientX, clientY } = touch;
                this.#startPoint = { x: clientX, y: clientY }
                document.addEventListener('touchmove', this.#handleTouchMove);
                this.element.style.transition = 'transform 0s';
            });

            document.addEventListener('touchend', this.#handleTouchEnd);
            document.addEventListener('cancel', this.#handleTouchEnd);
        }

        #listenToMouseEvents = () => {
            this.element.addEventListener('mousedown', (e) => {
                const { clientX, clientY } = e;
                this.#startPoint = { x: clientX, y: clientY }
                document.addEventListener('mousemove', this.#handleMouseMove);
                this.element.style.transition = 'transform 0s';
            });

            document.addEventListener('mouseup', this.#handleMoveUp);

            this.element.addEventListener('dragstart', (e) => {
                e.preventDefault();
            });
        }

        #handleMove = (x, y) => {
            if (swipeLimitReached) {
                return; // Prevent movement if swipe limit is reached
            }
            this.#offsetX = x - this.#startPoint.x;
            this.#offsetY = y - this.#startPoint.y;
            const rotate = this.#offsetX * 0.1;
            this.element.style.transform = `translate(${this.#offsetX}px, ${this.#offsetY}px) rotate(${rotate}deg)`;
            if (Math.abs(this.#offsetX) > this.element.clientWidth * 0.7) {
                this.#dismiss(this.#offsetX > 0 ? 1 : -1);
            } else if (this.#offsetY < -this.element.clientHeight * 0.5) {
                this.#showDetails();
            }
        }

        #handleMouseMove = (e) => {
            e.preventDefault();
            if (!this.#startPoint) return;
            const { clientX, clientY } = e;
            this.#handleMove(clientX, clientY);
        }

        #handleMoveUp = () => {
            this.#startPoint = null;
            document.removeEventListener('mousemove', this.#handleMouseMove);
            this.element.style.transform = '';
        }

        #handleTouchMove = (e) => {
            if (!this.#startPoint) return;
            const touch = e.changedTouches[0];
            if (!touch) return;
            const { clientX, clientY } = touch;
            this.#handleMove(clientX, clientY);
        }

        #handleTouchEnd = () => {
            this.#startPoint = null;
            document.removeEventListener('touchmove', this.#handleTouchMove);
            this.element.style.transform = '';
        }

        #dismiss = (direction) => {
            this.#startPoint = null;
            document.removeEventListener('mouseup', this.#handleMoveUp);
            document.removeEventListener('mousemove', this.#handleMouseMove);
            document.removeEventListener('touchend', this.#handleTouchEnd);
            document.removeEventListener('touchmove', this.#handleTouchMove);
            this.element.style.transition = 'transform 1s';
            this.element.style.transform = `translate(${direction * window.innerWidth}px, ${this.#offsetY}px) rotate(${90 * direction}deg)`;
            this.element.classList.add('dismissing');
            setTimeout(() => {
                this.element.remove();
                if (!swipeLimitReached) {
                    appendNewCard();
                }
            }, 1000);
            if (typeof this.onDismiss === 'function') {
                this.onDismiss();
            }
            if (typeof this.onLike === 'function' && direction === 1) {
                this.onLike();
                this.#sendSwipeAction('like');
            }
            if (typeof this.onDislike === 'function' && direction === -1) {
                this.onDislike();
                this.#sendSwipeAction('dislike');
            }
        }

        #sendSwipeAction = (action) => {
            const swipeData = {
                _token: '{{ csrf_token() }}',
                freelancer_id: {{ $freelancer->id }},
                job_id: this.job.id,
                action: action
            };

            // console.log('Sending swipe action:', swipeData);

            $.ajax({
                url: '{{ route('swipe') }}',
                type: 'POST',
                data: swipeData,
                success: function(response) {
                    // console.log('Swipe action successful:', response);
                    if (response.status === 'error' && response.message === 'You have reached your swipe limit for today.') {
                        alert(response.message);
                        swipeLimitReached = true; // Set the flag to true
                    }
                },
                error: function(error) {
                    // console.error('Error in swipe action:', error);
                    if (error.status === 403) {
                        alert(error.responseJSON.message);
                        swipeLimitReached = true; // Set the flag to true
                    }
                }
            });
        }
    }

    const swiper = document.querySelector('#swiper');
    const like = document.querySelector('#like');
    const dislike = document.querySelector('#dislike');

    const jobs = @json($jobs);
    let cardCount = 0;

    const maxCards = Math.min(jobs.length, @json($swipeLimit - $swipeCount)); // Calculate the number of cards to show

    function appendNewCard() {
        if (cardCount >= maxCards || swipeLimitReached) return; // Check the swipe limit flag

        const job = jobs[cardCount];
        const card = new Card({
            job: job,
            onDismiss: () => {
                appendNewCard();
            },
            onLike: () => {
                like.style.animationPlayState = 'running';
                like.classList.toggle('trigger');
            },
            onDislike: () => {
                dislike.style.animationPlayState = 'running';
                dislike.classList.toggle('trigger');
            }
        });
        swiper.append(card.element);
        cardCount++;

        const cards = swiper.querySelectorAll('.card:not(.dismissing)');
        cards.forEach((card, index) => {
            card.style.setProperty('--i', index);
        });
    }

    for (let i = 0; i < Math.min(5, maxCards); i++) { // Show only the number of cards allowed by the limit
        appendNewCard();
    }

    const modal = document.getElementById('jobModal');
    const closeModal = document.getElementsByClassName('close')[0];

    closeModal.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    function formatSalary(salary) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(salary);
    }

    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
    }
</script>

</div>
</div>
@else
<div class="container">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif
    <div class="row justify-content-center mt-3">
        <div class="col-12 text-center d-flex justify-content-center align-items-center" style="position: relative;">
            <h1 class="my-2">Jobs</h1>
            <a href="#" class="nav-link" role="button" id="addJobButton" style="position: absolute; right: 0;">
                <img src="{{ asset('storage/icon/add.png') }}" style="width: 30px; height: 30px;">
            </a>
        </div>
    </div>

    @if($jobs->isEmpty())
        <p class="text-center mt-4">No jobs available at the moment.</p>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
            @foreach ($jobs as $job)
            <?php
                $format_number = number_format($job->salary, 2, ',', '.');
                $format_date = date('d-m-Y', strtotime($job->project_deadline));
            ?>
            <div class="col mb-4">
                <div class="card text-white {{ $job->status == 'closed' ? 'bg-danger' : 'bg-primary' }}" style="width: 15rem; margin: 5px;">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: rgb(65, 165, 238); height: 3rem;">
                        <h5 class="card-title mb-0">{{ $job->project_name }}</h5>
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('storage/icon/menu.png') }}" style="width: 30px; height: 30px;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/editJob/{{ $job->id }}">Edit</a></li>
                            <li><hr class="dropdown-divider"></li>
                            @if ($job->status == 'open')
                                <li><a class="dropdown-item" onclick="closeJob('{{ $job->id }}')">Close</a></li>
                            @else
                                <li><a class="dropdown-item" onclick="openJob('{{ $job->id }}')">Open</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" onclick="showDeleteModal('{{ $job->id }}', '{{ $job->project_name }}')">Delete</a></li>
                        </ul>
                    </div>
                    <a href="/matches?job_id={{ $job->id }}" class="card-body" style="height: 12rem; text-decoration: none">
                        <p class="card-text">Project Type: {{ $job->project_type }}</p>
                        <p id="status-{{ $job->id }}" class="card-text">Status: {{ $job->status }}</p>
                        <p class="card-text">Deadline: {{ $format_date }}</p>
                        <p class="card-text">Salary: Rp.{{ $format_number }}</p>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div id="deleteModalMessage" class="card-header text-white bg-primary" style="font-size: x-large; text-align: center; border-radius: 10px; padding:5px;"></div>
        <div class="button-container">
            <button id="confirmDelete" class="btnCon btn-danger">Yes</button>
            <button id="cancelDelete" class="btnCon btn-primary">No</button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <p>Job deleted successfully!</p>
    </div>
</div>

<style>
    .d-flex.justify-content-between.align-items-center {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .text-center {
        text-align: center;
    }

    .position-relative {
        position: relative;
    }

    .position-absolute {
        position: absolute;
    }

    .right-0 {
        right: 0;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8); /* Darker background */
    }

    .modal-content {
        background-color: #333; /* Dark background for content */
        color: white; /* White text for better readability */
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 10px;
        text-align: center;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .btnCon {
        width: 100px;
        margin: 10px;
        padding: 10px;
        border-radius: 5px;
        font-size: 16px;
    }

    .btn-danger {
        background-color: red;
        color: white;
        border: none;
    }

    .btn-primary {
        background-color: blue;
        color: white;
        border: none;
    }

    .btn:hover {
        opacity: 0.8;
    }
</style>

<script>
    $(document).ready(function () {
        $('#addJobButton').on('click', function(event) {
            event.preventDefault();
            var canAddJob = {{ $canAddJob ? 'true' : 'false' }};
            if (!canAddJob) {
                alert('You have reached the job limit. Upgrade your plan to add more jobs.');
            } else {
                window.location.href = '/addJob';
            }
        });
    });

    let deleteJobId = null;

    function showDeleteModal(jobId, projectName) {
        var deleteModal = document.getElementById('deleteModal');
        var deleteModalMessage = document.getElementById('deleteModalMessage');
        deleteModalMessage.textContent = `Are you sure you want to delete "${projectName}" job?`;
        deleteModal.style.display = 'block';

        document.getElementById('confirmDelete').onclick = function() {
            deleteJobConfirmed(jobId);
        };

        document.getElementById('cancelDelete').onclick = function() {
            closeDeleteModal();
        };
    }

    function closeDeleteModal() {
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.style.display = 'none';
    }

    function deleteJobConfirmed(jobId) {
        $.ajax({
            url: '/deleteJob/' + jobId,
            type: "DELETE",
            data: {"_token": "{{ csrf_token() }}"},
            dataType: "json",
            success: function(response) {
                const jobCard = document.getElementById('job-' + jobId);
                if (jobCard) {
                    jobCard.remove();
                }
                showSuccessModal('Job deleted successfully!');
                closeDeleteModal();
            },
            error: function(error) {
                // console.error('Error deleting job:', error);
                closeDeleteModal();
            }
        });
    }

    function closeJob(jobId) {
        $.ajax({
            url: '/closeJob/' + jobId,
            type: "GET",
            data: {"_token": "{{ csrf_token() }}"},
            dataType: "json",
            success: function(response) {
                const statusElement = document.getElementById('status-' + jobId);
                if (statusElement) {
                    statusElement.innerHTML = 'Status: closed';
                    statusElement.closest('.card').classList.remove('bg-primary');
                    statusElement.closest('.card').classList.add('bg-danger');
                }
                showSuccessModal('Job closed successfully!');
            },
            error: function(error) {
                // console.error('Error closing job:', error);
            }
        });
    }

    function openJob(jobId) {
        $.ajax({
            url: '/openJob/' + jobId,
            type: "GET",
            data: {"_token": "{{ csrf_token() }}"},
            dataType: "json",
            success: function(response) {
                const statusElement = document.getElementById('status-' + jobId);
                if (statusElement) {
                    statusElement.innerHTML = 'Status: open';
                    statusElement.closest('.card').classList.remove('bg-danger');
                    statusElement.closest('.card').classList.add('bg-primary');
                }
                showSuccessModal('Job opened successfully!');
            },
            error: function(error) {
                // console.error('Error opening job:', error);
            }
        });
    }

    function showSuccessModal(message) {
        var successModal = document.getElementById('successModal');
        successModal.querySelector('p').textContent = message;
        successModal.style.display = 'block';

        // Disable user interaction
        $('body').css('pointer-events', 'none');

        setTimeout(function() {
            successModal.style.display = 'none';
            $('body').css('pointer-events', 'auto');
            location.reload(); // Redirect to home after the modal disappears
        }, 1000);
    }
</script>

@endif

@endsection
