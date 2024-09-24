@extends('layouts.nav2')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <h1 class="text-center m-2">{{ __('Matches') }}</h1>
            <a class="text-center m-2 popup-trigger" href="#" role="button" aria-expanded="false">
                <img src="{{asset('storage/icon/filter.png')}}" style="width: 50px; height: 50px;">
            </a>
            <!-- Popup Content -->
            <div class="popup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; justify-content: center; align-items: center;">
                <div class="card popup-content" style="background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.5); width: 50%; max-height: 40%; overflow: auto; position: relative;">
                    <form action="/matches/filter/{{ $job->id }}" method="POST" style="text-align: center">
                        @csrf
                        <div class="input-group" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <p class="mt-3" style="font-weight: bold;">Select Section</p>
                            <select name="section_filter" style="width: 80%; margin-top: 10px; padding: 10px; border-radius: 5px; border: 1px solid #ccc;" id="section_filter" class="form-control" aria-label="Select Section">
                                <option value="" disabled selected>Choose Job Section</option>
                                @foreach ($sections as $s)
                                    @if ($s->fields_id == $job->project_field)
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
            <div id="freelancerModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form>
                        <div class="form-group">
                            <label for="modalFreelancerName">Freelancer Name</label>
                            <input type="text" id="modalFreelancerName" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="modalLastStudy">Last Study</label>
                            <input type="text" id="modalLastStudy" class="form-control" readonly>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="modalField">Field of Work</label>
                                <input type="text" id="modalField" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="modalSections">Sections</label>
                                <input type="text" id="modalSections" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="modalCVLink">CV Link</label>
                            <a id="modalCVLink" class="btn btn-primary" download>Download CV</a>
                        </div>
                        <div class="form-group">
                            <label for="modalSalary">Salary</label>
                            <input type="text" id="modalSalary" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="modalPortfolio">Portfolio</label>
                            <input type="text" id="modalPortfolio" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="modalDescription">Describe Yourself</label>
                            <textarea id="modalDescription" class="form-control" readonly></textarea>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function formatSalary(minSalary, maxSalary) {
                    const formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                    });
                    return `${formatter.format(minSalary)} - ${formatter.format(maxSalary)}`;
                }

                let swipeLimitReached = false; // Flag to track swipe limit
                let swipeCount = @json($swipeCount); // Get current swipe count from backend
                const swipeLimit = @json($swipeLimit); // Get swipe limit from backend

                class Card {
                    constructor({ freelancer, onDismiss, onLike, onDislike }) {
                        this.freelancer = freelancer;
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
                        const card = document.createElement('div');
                        card.classList.add('card');

                        const img = document.createElement('img');
                        img.src = `/storage/img/${this.freelancer.freelancer_image_link}`;
                        card.append(img);

                        const content = document.createElement('div');
                        content.classList.add('card-content');
                        content.innerHTML = `
                            <h5>${this.freelancer.freelancer_name}</h5>
                            <p>${this.freelancer.field.fields_of_work}</p>
                            <p>${this.#getSections()}</p>
                        `;
                        card.append(content);

                        this.element = card;
                        if (this.#isTouchDevice()) {
                            this.#listenToTouchEvents();
                        } else {
                            this.#listenToMouseEvents();
                        }
                    }

                    #getSections = () => {
                        let sections = [];
                        if (this.freelancer.section1) sections.push(this.freelancer.section1.section);
                        if (this.freelancer.section2) sections.push(this.freelancer.section2.section);
                        if (this.freelancer.section3) sections.push(this.freelancer.section3.section);
                        return sections.join(', ');
                    }

                    #showDetails = () => {
                        document.getElementById('modalFreelancerName').value = this.freelancer.freelancer_name;
                        document.getElementById('modalLastStudy').value = this.freelancer.last_study;
                        document.getElementById('modalField').value = this.freelancer.field.fields_of_work;
                        document.getElementById('modalSections').value = this.#getSections();
                        document.getElementById('modalCVLink').href = `/storage/cv/${this.freelancer.cv_link}`;
                        document.getElementById('modalCVLink').innerText = this.freelancer.cv_link;
                        document.getElementById('modalSalary').value = formatSalary(this.freelancer.min_salary, this.freelancer.max_salary);
                        document.getElementById('modalPortfolio').value = this.freelancer.portfolio;
                        document.getElementById('modalDescription').value = this.freelancer.describe_yourselves;
                        document.getElementById('freelancerModal').style.display = 'block';
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
                            freelancer_id: this.freelancer.id,
                            job_id: {{ $job->id }},
                            action: action
                        };

                        // console.log('Sending swipe action:', swipeData);

                        $.ajax({
                            url: '{{ route('swipe') }}',
                            type: 'POST',
                            data: swipeData,
                            success: function(response) {
                                // console.log('Swipe action successful:', response);
                                swipeCount++; // Increment swipe count on successful swipe
                                if (swipeCount >= swipeLimit) {
                                    swipeLimitReached = true; // Set the flag to true if limit is reached
                                }
                            },
                            error: function(error) {
                                // console.error('Error in swipe action:', error);
                            }
                        });
                    }
                }

                const swiper = document.querySelector('#swiper');
                const like = document.querySelector('#like');
                const dislike = document.querySelector('#dislike');

                const freelancers = @json($freelancers);
                let cardCount = 0;
                const maxCards = Math.min(freelancers.length, swipeLimit - swipeCount); // Calculate the number of cards to show based on swipe limit

                function appendNewCard() {
                    if (cardCount >= maxCards || swipeLimitReached) return; // Check the swipe limit flag

                    const freelancer = freelancers[cardCount];
                    const card = new Card({
                        freelancer: freelancer,
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

                // Modal functionality
                const modal = document.getElementById('freelancerModal');
                const closeModal = document.getElementsByClassName('close')[0];

                closeModal.onclick = function() {
                    modal.style.display = 'none';
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = 'none';
                    }
                }
            </script>
@endsection
