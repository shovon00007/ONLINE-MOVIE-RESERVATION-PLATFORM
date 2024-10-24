@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="review-container shadow-lg p-5 rounded" style="background-image: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
        <h1 class="text-center mb-4 text-highlight">Reviews for {{ $movie->title }}</h1>

        @if (session('success'))
            <div class="alert alert-success fadeIn">
                {{ session('success') }}
            </div>
        @endif

        <!-- Review Submission or Edit Form -->
        <form action="{{ route('movies.reviews.store', $movie->id) }}" method="POST" class="review-form p-4 rounded" style="background: #ffffff; border: 2px solid #f6d365;">
            @csrf
            <div class="form-group">
                <label for="review" class="form-label">{{ $userReview ? 'Edit Your Review:' : 'Your Review:' }}</label>
                <textarea name="review" id="review" class="form-control" rows="4" required>{{ $userReview ? $userReview->review : '' }}</textarea>
            </div>
            <div class="form-group mt-3">
                <label for="rating" class="form-label">Rating:</label>
                <div class="rating-container">
                    <!-- Star Rating Display for real-time selection -->
                    <input type="hidden" name="rating" id="rating" class="rating-input" required value="{{ $userReview ? $userReview->rating : '' }}">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star star {{ $userReview && $userReview->rating >= $i ? 'selected' : '' }}" data-value="{{ $i }}"></i>
                        @endfor
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-gradient mt-4">{{ $userReview ? 'Update Review' : 'Submit Review' }}</button>
        </form>
        
        <!-- Display Reviews -->
        <h2 class="mt-5 text-highlight">User Reviews</h2>
        @if($reviews->isEmpty())
            <p>No reviews yet.</p>
        @else
            <ul class="list-group review-list mt-3">
                @foreach($reviews as $review)
                    <li class="list-group-item review-item shadow-lg">
                        <strong class="review-author">{{ $review->user->name }}</strong> 
                        <span class="review-rating"> 
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'filled' : '' }}"></i>
                            @endfor
                        </span>
                        <p class="mt-2">{{ $review->review }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<style>
    /* General container styling */
    .container {
        max-width: 850px;
        padding: 20px;
        border-radius: 15px;
    }

    .review-container {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        padding: 40px;
        border-radius: 20px;
    }

    .text-highlight {
        font-size: 2.5rem;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        color: #ffffff;
    }

    /* Form styling */
    .review-form {
        background-color: #fff;
        border: 2px solid #f093fb;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
    }

    .form-control {
        border: 2px solid #ddd;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #f093fb;
        box-shadow: 0 0 10px rgba(240, 147, 251, 0.4);
    }

    /* Gradient Button Styling */
    .btn-gradient {
        background: linear-gradient(45deg, #f093fb, #f5576c);
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        background: linear-gradient(45deg, #f5576c, #f093fb);
        transform: scale(1.05);
    }

    /* Star rating container */
    .rating-container {
        display: flex;
        align-items: center;
    }

    .stars {
        cursor: pointer;
    }

    .star {
        font-size: 2.5rem;
        color: #ccc;
        transition: color 0.3s, transform 0.3s;
    }

    .star.selected, .star:hover, .star:hover ~ .star {
        color: #f39c12;
        transform: scale(1.2);
    }

    /* Review list styling */
    .review-list {
        padding: 0;
        list-style: none;
    }

    .review-item {
        padding: 20px;
        background-color: #fff;
        margin-bottom: 15px;
        border-radius: 10px;
        border: 2px solid #f093fb;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }

    .review-item:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
    }

    /* Animation for appearing reviews */
    .review-item {
        opacity: 0;
        transform: translateY(50px);
        animation: slideIn 0.6s forwards;
        animation-delay: calc(0.1s * var(--order));
    }

    @keyframes slideIn {
        0% {
            opacity: 0;
            transform: translateY(50px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .review-author {
        font-size: 1.5rem;
        color: #333;
    }

    .review-rating .fa-star.filled {
        color: #f39c12;
    }

    /* Alert fade in effect */
    .fadeIn {
        animation: fadeIn 1s forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.stars .star');
        const ratingInput = document.getElementById('rating');

        // Handle real-time rating display
        stars.forEach(star => {
            star.addEventListener('mouseenter', function() {
                clearStars();
                fillStars(star.dataset.value);
            });

            star.addEventListener('mouseleave', function() {
                clearStars();
                if (ratingInput.value) {
                    fillStars(ratingInput.value);
                }
            });

            star.addEventListener('click', function() {
                ratingInput.value = star.dataset.value;
                animateStarClick(this);
            });
        });

        function fillStars(rating) {
            stars.forEach(star => {
                if (star.dataset.value <= rating) {
                    star.classList.add('selected');
                }
            });
        }

        function clearStars() {
            stars.forEach(star => {
                star.classList.remove('selected');
            });
        }

        function animateStarClick(star) {
            // Animate star after click
            star.classList.add('bounce');
            setTimeout(() => star.classList.remove('bounce'), 1000);
        }

        // Bounce animation
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                star.style.animation = 'bounce 0.4s ease-in-out';
            });
        });

        // Fade out success alert after 3 seconds
        const alertBox = document.querySelector('.alert-success');
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.add('fadeOut');
                alertBox.style.opacity = 0;
            }, 3000);
        }
    });
</script>
@endsection
