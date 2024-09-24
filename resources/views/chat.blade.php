@extends('layouts.nav2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-100">
            <div class="card mt-4">
                <div class="card-header bg-info" style="color: #3cb0e8">{{ __('Chats') }}</div>

                <div class="card-body" style="min-height:400px; max-height: 400px; overflow-y: auto;" id="chat-body">
                    <ul class="list-unstyled" id="chat-list">
                        @foreach($chats as $chat)
                            <li class="chat-bubble {{ $chat->sender == $users->id ? 'chat-bubble-right' : 'chat-bubble-left' }} mb-2">
                                @if ($users->role_id == 2 && $chat->sender == $users->id)
                                    @if (isset($myName->employer_image_link))
                                        <img src="{{ asset('storage/img/' . $myName->employer_image_link) }}" alt="{{ $myName->employer_name }}" data-role="2" data-type="{{ $myName->employer_type }}" class="rounded-circle me-2 profile-picture" style="width: 40px; height: 40px;">
                                    @endif
                                    <div class="chat-content">{{ $myName->employer_name }}: {{ $chat->message }}</div>
                                @elseif ($users->role_id == 1 && $chat->sender == $users->id)
                                    @if (isset($myName->freelancer_image_link))
                                        <img src="{{ asset('storage/img/' . $myName->freelancer_image_link) }}" alt="{{ $myName->freelancer_name }}"
                                            data-last-study="{{ $myName->last_study }}"
                                            data-field-of-work="{{ $myName->field->fields_of_work }}"
                                            data-cv-link="{{ $myName->cv_link }}"
                                            data-portfolio="{{ $myName->portfolio }}"
                                            data-min-salary="{{ $myName->min_salary }}"
                                            data-max-salary="{{ $myName->max_salary }}"
                                            data-section-1="{{ $myName->section1->section }}"
                                            data-section-2="{{ $myName->section2->section }}"
                                            data-section-3="{{ $myName->section3->section }}"
                                            data-describe-yourselves="{{ $myName->describe_yourselves }}"
                                            data-role="1" data-project-name="{{ $jobs->firstWhere('id', $chat->job_id)->project_name ?? '' }}" data-project-field="{{ $jobs->firstWhere('id', $chat->job_id)->field->fields_of_work ?? '' }}" class="rounded-circle me-2 profile-picture" style="width: 40px; height: 40px;">
                                    @endif
                                    <div class="chat-content">{{ $myName->freelancer_name }}: {{ $chat->message }}</div>
                                @elseif ($users->role_id == 2 && $chat->sender != $users->id)
                                    @if (isset($chatWith->freelancer_image_link))
                                        <img src="{{ asset('storage/img/' . $chatWith->freelancer_image_link) }}" alt="{{ $chatWith->freelancer_name }}"
                                            data-last-study="{{ $chatWith->last_study }}"
                                            data-field-of-work="{{ $chatWith->field->fields_of_work }}"
                                            data-cv-link="{{ $chatWith->cv_link }}"
                                            data-portfolio="{{ $chatWith->portfolio }}"
                                            data-min-salary="{{ $chatWith->min_salary }}"
                                            data-max-salary="{{ $chatWith->max_salary }}"
                                            data-section-1="{{ $chatWith->section1->section }}"
                                            data-section-2="{{ $chatWith->section2->section }}"
                                            data-section-3="{{ $chatWith->section3->section }}"
                                            data-describe-yourselves="{{ $chatWith->describe_yourselves }}"
                                            data-role="1" data-project-name="{{ $jobs->firstWhere('id', $chat->job_id)->project_name ?? '' }}" data-project-field="{{ $jobs->firstWhere('id', $chat->job_id)->field->fields_of_work ?? '' }}" class="rounded-circle me-2 profile-picture" style="width: 40px; height: 40px;">
                                    @endif
                                    <div class="chat-content">{{ $chatWith->freelancer_name }}: {{ $chat->message }}</div>
                                @elseif ($users->role_id == 1 && $chat->sender != $users->id)
                                    @if (isset($chatWith->employer_image_link))
                                        <img src="{{ asset('storage/img/' . $chatWith->employer_image_link) }}" alt="{{ $chatWith->employer_name }}" data-role="2" data-type="{{ $chatWith->employer_type }}" class="rounded-circle me-2 profile-picture" style="width: 40px; height: 40px;">
                                    @endif
                                    <div class="chat-content">{{ $chatWith->employer_name }}: {{ $chat->message }}</div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-4">
                    <form action="/chat/{{ $matched->id }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" id="message" class="form-control" placeholder="Type your message" aria-label="Type your message" aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="submit" id="button-addon2">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function fetchChats() {
                $.ajax({
                    url: '/chat-data/{{ $matched->id }}',
                    method: 'GET',
                    success: function (data) {
                        let chatList = '';
                        data.forEach(chat => {
                            let chatBubbleClass = chat.sender == {{ $users->id }} ? 'chat-bubble-right' : 'chat-bubble-left';
                            let chatContent = '';
                            if ({{ $users->role_id }} == 2 && chat.sender == {{ $users->id }}) {
                                chatContent = '{{ $myName->employer_name }}: ' + chat.message;
                            } else if ({{ $users->role_id }} == 1 && chat.sender == {{ $users->id }}) {
                                chatContent = '{{ $myName->freelancer_name }}: ' + chat.message;
                            } else if ({{ $users->role_id }} == 2 && chat.sender != {{ $users->id }}) {
                                chatContent = '{{ $chatWith->freelancer_name }}: ' + chat.message;
                            } else if ({{ $users->role_id }} == 1 && chat.sender != {{ $users->id }}) {
                                chatContent = '{{ $chatWith->employer_name }}: ' + chat.message;
                            }
                            chatList += `
                                <li class="chat-bubble ${chatBubbleClass} mb-2">
                                    <div class="chat-content">${chatContent}</div>
                                </li>
                            `;
                        });
                        $('#chat-list').html(chatList);
                        scrollToBottom();
                    }
                });
            }

            function scrollToBottom() {
                let chatBody = document.getElementById('chat-body');
                chatBody.scrollTop = chatBody.scrollHeight;
            }

            $(document).ready(function () {
                setInterval(fetchChats, 5000); // Fetch chat data every 5 seconds
                scrollToBottom(); // Initial scroll to bottom
            });
        </script>

        </div>
        <!-- New div for job list -->
        <div class="col-md-4">
            <div class="card mt-4">
                <div class="card-header bg-info" style="color: #3cb0e8">{{ __('Jobs List') }}</div>
                <div class="card-body" style="min-height:400px; max-height: 400px; overflow-y: auto;">
                    <ul class="list-unstyled">
                        @foreach($jobs as $job)
                            <li class="job-bubble mb-2 p-3 d-flex align-items-center job-item"
                                data-employer-name="{{ $job->employer->employer_name }}"
                                data-employer-type="{{ $job->employer->employer_type }}"
                                data-project-name="{{ $job->project_name }}"
                                data-project-field="{{ $job->field->fields_of_work }}"
                                data-project-type="{{ $job->project_type }}"
                                data-project-description="{{ $job->project_description }}"
                                data-salary="{{ $job->salary }}"
                                data-project-deadline="{{ $job->project_deadline }}"
                                data-image="{{ $job->employer->employer_image_link }}">
                                @if (isset($job->employer->employer_image_link))
                                    <img src="{{ asset('storage/img/' . $job->employer->employer_image_link) }}" alt="{{ $job->employer->employer_name }}" class="rounded-circle me-2 profile-picture" style="width: 40px; height: 40px;">
                                @endif
                                <div>
                                    <div>{{ $job->project_name }}</div>
                                    <div>{{ $job->field->fields_of_work }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup Modal for Profile Details -->
<div id="profileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="freelancerDetails" style="display: none;">
            <div class="form-group">
                <img id="modalFreelancerImage" src="" alt="Profile Image" style="width: 100%;">
            </div>
            <div class="form-group">
                <label for="modalFreelancerName">Freelancer Name</label>
                <input type="text" id="modalFreelancerName" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalFreelancerLastStudy">Last Study</label>
                <input type="text" id="modalFreelancerLastStudy" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalFreelancerFieldOfWork">Field of Work</label>
                <input type="text" id="modalFreelancerFieldOfWork" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalFreelancerCV">CV Link</label>
                <a href="#" id="modalFreelancerCV" class="form-control btn btn-primary" style="text-align: left;" download></a>
            </div>
            <div class="form-group">
                <label for="modalFreelancerSalary">Salary</label>
                <input type="text" id="modalFreelancerSalary" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalFreelancerPortfolio">Portfolio</label>
                <input type="text" id="modalFreelancerPortfolio" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalFreelancerDescription">Describe Yourself</label>
                <textarea id="modalFreelancerDescription" class="form-control" readonly></textarea>
            </div>
        </form>

        <form id="employerDetails" style="display: none;">
            <div class="form-group">
                <img id="modalEmployerImage" src="" alt="Profile Image" style="width: 100%;">
            </div>
            <div class="form-group">
                <label for="modalEmployerName">Employer Name</label>
                <input type="text" id="modalEmployerName" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modalEmployerType">Type</label>
                <input type="text" id="modalEmployerType" class="form-control" readonly>
            </div>
        </form>
    </div>
</div>

<div id="jobModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="form-group">
            <label for="modalProjectName">Project Name</label>
            <input type="text" id="modalProjectName" class="form-control" readonly>
        </div>
        <div class="form-group">
            <label for="modalProjectField">Project Field</label>
            <input type="text" id="modalProjectField" class="form-control" readonly>
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
    </div>
</div>

<style>
    .job-bubble {
        background-color: #004080; /* Dark blue color for the bubble */
        color: #fff; /* White text color for better contrast */
        border-radius: 15px;
        padding: 10px;
        display: flex;
        align-items: center;
    }

    .job-bubble img {
        border-radius: 50%;
        margin-right: 10px;
        width: 40px;
        height: 40px;
    }

    .job-bubble div {
        display: flex;
        flex-direction: column;
    }

    .job-bubble div div {
        color: #fff; /* Ensure text color is white for better contrast */
    }

    .chat-bubble {
        padding: 10px;
        border-radius: 15px;
        max-width: 75%;
        position: relative;
        display: flex;
        align-items: center;
        color: #fff; /* Ensure text color is white for better contrast */
    }

    .chat-bubble-left {
        background-color: #004080; /* Dark blue color from the header */
        align-self: flex-start;
    }

    .chat-bubble-right {
        background-color: #00bfff; /* Light blue color from the header */
        align-self: flex-end;
        margin-left: auto;
    }

    .chat-bubble-left::before, .chat-bubble-right::before {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-style: solid;
    }

    .chat-bubble-left::before {
        border-width: 0 10px 10px 0;
        border-color: transparent #004080 transparent transparent; /* Match the left bubble background color */
        top: 0;
        left: -10px;
    }

    .chat-bubble-right::before {
        border-width: 10px 10px 0 0;
        border-color: #00bfff transparent transparent transparent; /* Match the right bubble background color */
        top: 0;
        right: -10px;
    }

    .profile-picture {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .chat-content {
        display: inline-block;
        vertical-align: middle;
        word-break: break-word;
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
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
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

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input,
    .form-group img,
    .form-group a,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .form-group a {
        display: inline-block;
        text-decoration: none;
        color: white;
        background-color: #007bff;
        text-align: center;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var profileModal = document.getElementById('profileModal');
        var jobModal = document.getElementById('jobModal');
        var closeProfileModal = profileModal.querySelector('.close');
        var closeJobModal = jobModal.querySelector('.close');

        var freelancerDetails = document.getElementById('freelancerDetails');
        var employerDetails = document.getElementById('employerDetails');
        var modalFreelancerImage = document.getElementById('modalFreelancerImage');
        var modalFreelancerName = document.getElementById('modalFreelancerName');
        var modalFreelancerLastStudy = document.getElementById('modalFreelancerLastStudy');
        var modalFreelancerFieldOfWork = document.getElementById('modalFreelancerFieldOfWork');
        var modalFreelancerSections = document.getElementById('modalFreelancerSections');
        var modalFreelancerCV = document.getElementById('modalFreelancerCV');
        var modalFreelancerSalary = document.getElementById('modalFreelancerSalary');
        var modalFreelancerPortfolio = document.getElementById('modalFreelancerPortfolio');
        var modalFreelancerDescription = document.getElementById('modalFreelancerDescription');
        var modalEmployerImage = document.getElementById('modalEmployerImage');
        var modalEmployerName = document.getElementById('modalEmployerName');
        var modalEmployerType = document.getElementById('modalEmployerType');
        var modalProjectName = document.getElementById('modalProjectName');
        var modalProjectField = document.getElementById('modalProjectField');
        var modalProjectType = document.getElementById('modalProjectType');
        var modalProjectDescription = document.getElementById('modalProjectDescription');
        var modalSalary = document.getElementById('modalSalary');
        var modalProjectDeadline = document.getElementById('modalProjectDeadline');

        function formatSalary(Salary) {
            const formattedSalary = `Rp ${Salary.toLocaleString()}`;
            return formattedSalary;
        }

        function showFreelancerModal(details) {
            // console.log('showFreelancerModal input:', details);
            freelancerDetails.style.display = 'block';
            employerDetails.style.display = 'none';

            modalFreelancerImage.src = `/storage/img/${details.image}`;
            modalFreelancerName.value = details.name;
            modalFreelancerLastStudy.value = details.last_study;
            modalFreelancerFieldOfWork.value = details.field_of_work;
            modalFreelancerCV.href = `/storage/cv/${details.cv_link}`;
            modalFreelancerCV.innerText = details.cv_link;
            modalFreelancerSalary.value = `${formatSalary(details.min_salary)} - ${formatSalary(details.max_salary)}`;
            modalFreelancerPortfolio.value = details.portfolio;
            modalFreelancerDescription.value = details.describe_yourselves;

            // console.log('showFreelancerModal elements updated');
            profileModal.style.display = 'block';
        }

        function showEmployerModal(details) {
            // console.log('showEmployerModal input:', details);
            freelancerDetails.style.display = 'none';
            employerDetails.style.display = 'block';

            modalEmployerImage.src = `/storage/img/${details.image}`;
            modalEmployerName.value = details.name;
            modalEmployerType.value = details.type;

            // console.log('showEmployerModal elements updated');
            profileModal.style.display = 'block';
        }

        function showJobModal(details) {
            // console.log('showJobModal input:', details);

            modalProjectName.value = details.project_name;
            modalProjectField.value = details.project_field;
            modalProjectType.value = details.project_type;
            modalProjectDescription.value = details.project_description;
            modalSalary.value = formatSalary(details.salary);
            modalProjectDeadline.value = details.project_deadline;

            // console.log('showJobModal elements updated');
            jobModal.style.display = 'block';
        }

        var profilePictures = document.querySelectorAll('.profile-picture');
        profilePictures.forEach(picture => {
            picture.addEventListener('click', function() {
                var details = {
                    image: this.src.split('/').pop(),
                    name: this.alt,
                    last_study: this.dataset.lastStudy,
                    field_of_work: this.dataset.fieldOfWork,
                    'section-1': this.dataset.section1,
                    'section-2': this.dataset.section2,
                    'section-3': this.dataset.section3,
                    cv_link: this.dataset.cvLink,
                    min_salary: parseInt(this.dataset.minSalary, 10),
                    max_salary: parseInt(this.dataset.maxSalary, 10),
                    portfolio: this.dataset.portfolio,
                    describe_yourselves: this.dataset.describeYourselves,
                    type: this.dataset.type // Employer type
                };
                // console.log('profilePicture click details:', details);
                if (this.dataset.role == '1') {
                    showFreelancerModal(details);
                } else if (this.dataset.role == '2') {
                    showEmployerModal(details);
                }
            });
        });

        var jobItems = document.querySelectorAll('.job-item');
        jobItems.forEach(item => {
            item.addEventListener('click', function() {
                var details = {
                    image: this.dataset.image,
                    name: this.dataset.employerName,
                    type: this.dataset.employerType,
                    project_name: this.dataset.projectName,
                    project_field: this.dataset.projectField,
                    project_type: this.dataset.projectType,
                    project_description: this.dataset.projectDescription,
                    salary: parseInt(this.dataset.salary, 10),
                    project_deadline: this.dataset.projectDeadline
                };
                // console.log('jobItem click details:', details);
                showJobModal(details);
            });
        });

        closeProfileModal.onclick = function() {
            profileModal.style.display = 'none';
        }

        closeJobModal.onclick = function() {
            jobModal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == profileModal) {
                profileModal.style.display = 'none';
            } else if (event.target == jobModal) {
                jobModal.style.display = 'none';
            }
        }
    });
</script>
@endsection
