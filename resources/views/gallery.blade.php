@include('components.auth-navbar')

@extends('layouts.app')

@section('content')
<style>
    body { 
        background: #fff;
        scroll-behavior: smooth;
    }
    .gallery-main {
        padding: 80px 0;
        background: #fff;
    }
    .gallery-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .gallery-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: #b48b8b;
        margin-bottom: 1rem;
    }
    .gallery-subtitle {
        text-align: center;
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }
    .gallery-item {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(184, 134, 134, 0.25);
    }
    
    @media (hover: hover) {
        .gallery-item:hover {
            transform: translateY(-5px);
        }
    }
    .gallery-image {
        width: 100%;
        height: 250px;
        overflow: hidden;
    }
    .gallery-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .gallery-item:hover .gallery-image img {
        transform: scale(1.05);
    }
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
        padding: 1.5rem;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }
    .gallery-item:hover .gallery-overlay {
        transform: translateY(0);
    }
    .gallery-overlay h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .gallery-overlay p {
        font-size: 0.9rem;
        opacity: 0.9;
        line-height: 1.4;
    }
    .gallery-filters {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    .filter-btn {
        padding: 0.5rem 1rem;
        border: 2px solid #b48b8b;
        background: transparent;
        color: #b48b8b;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .filter-btn:hover,
    .filter-btn.active {
        background: #b48b8b;
        color: white;
    }
    .gallery-search {
        text-align: center;
        margin-bottom: 2rem;
    }
    .gallery-search input {
        padding: 0.75rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        width: 300px;
        max-width: 100%;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.3s ease;
    }
    .gallery-search input:focus {
        border-color: #b48b8b;
    }
    .no-gallery-items {
        text-align: center;
        padding: 3rem;
        color: #666;
        font-size: 1.1rem;
    }
    
    /* Tablet Styles */
    @media (max-width: 1024px) {
        .gallery-main {
            padding: 60px 0;
        }
        
        .gallery-container {
            padding: 0 30px;
        }
        
        .gallery-title {
            font-size: 2.2rem;
        }
        
        .gallery-subtitle {
            font-size: 1rem;
            margin-bottom: 2.5rem;
        }
        
        .gallery-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 1.2rem;
            margin-top: 2.5rem;
        }
        
        .gallery-image {
            height: 220px;
        }
    }
    
    @media (max-width: 900px) {
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    /* Mobile Styles */
    @media (max-width: 768px) {
        .gallery-main {
            padding: 40px 0;
        }
        
        .gallery-container {
            padding: 0 20px;
        }
        
        .gallery-title {
            font-size: 1.8rem;
            margin-bottom: 0.8rem;
        }
        
        .gallery-subtitle {
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }
        
        .gallery-search {
            margin-bottom: 1.5rem;
        }
        
        .gallery-search input {
            width: 100%;
            padding: 0.65rem 1rem;
            font-size: 0.95rem;
        }
        
        .gallery-filters {
            gap: 0.8rem;
            margin-bottom: 1.5rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #b48b8b #f0f0f0;
        }
        
        .gallery-filters::-webkit-scrollbar {
            height: 4px;
        }
        
        .gallery-filters::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 4px;
        }
        
        .gallery-filters::-webkit-scrollbar-thumb {
            background: #b48b8b;
            border-radius: 4px;
        }
        
        .filter-btn {
            padding: 0.4rem 0.9rem;
            font-size: 0.9rem;
            white-space: nowrap;
            flex-shrink: 0;
        }
        
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .gallery-image {
            height: 180px;
        }
        
        .gallery-overlay {
            transform: translateY(0);
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.85));
            padding: 1rem;
        }
        
        .gallery-overlay h3 {
            font-size: 0.95rem;
            margin-bottom: 0.3rem;
        }
        
        .gallery-overlay p {
            font-size: 0.8rem;
        }
        
        .gallery-item:hover {
            transform: none;
        }
        
        .gallery-item:hover .gallery-image img {
            transform: none;
        }
        
        .no-gallery-items {
            padding: 2rem;
            font-size: 1rem;
        }
    }
    
    /* Extra Small Mobile */
    @media (max-width: 480px) {
        .gallery-main {
            padding: 30px 0;
        }
        
        .gallery-container {
            padding: 0 15px;
        }
        
        .gallery-title {
            font-size: 1.6rem;
        }
        
        .gallery-subtitle {
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .gallery-search {
            margin-bottom: 1.2rem;
        }
        
        .gallery-search input {
            padding: 0.6rem 0.9rem;
            font-size: 0.9rem;
        }
        
        .gallery-filters {
            gap: 0.6rem;
            margin-bottom: 1.2rem;
        }
        
        .filter-btn {
            padding: 0.35rem 0.8rem;
            font-size: 0.85rem;
        }
        
        .gallery-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .gallery-item {
            border-radius: 12px;
        }
        
        .gallery-image {
            height: 250px;
        }
        
        .gallery-overlay {
            padding: 0.9rem;
        }
        
        .gallery-overlay h3 {
            font-size: 0.9rem;
        }
        
        .gallery-overlay p {
            font-size: 0.75rem;
        }
        
        .no-gallery-items {
            padding: 1.5rem;
            font-size: 0.95rem;
        }
    }
    
    /* Touch device optimization */
    @media (hover: none) {
        .gallery-overlay {
            transform: translateY(0);
        }
        
        .gallery-item:hover {
            transform: none;
        }
        
        .gallery-item:hover .gallery-image img {
            transform: none;
        }
    }
</style>

<div class="gallery-main">
    <div class="gallery-container">
        <h1 class="gallery-title">Our Work</h1>
        <p class="gallery-subtitle">Browse through our gallery of stunning nail extension transformations</p>
        
        <!-- Search Bar -->
        <div class="gallery-search">
            <input type="text" id="gallery-search" placeholder="Search gallery items..." autocomplete="off">
        </div>
        
        <!-- Filter Buttons -->
        <div class="gallery-filters">
            <button class="filter-btn active" data-category="all">All</button>
            <button class="filter-btn" data-category="nail_extension">Nail Extensions</button>
            <button class="filter-btn" data-category="pedicure">Pedicures</button>
            <button class="filter-btn" data-category="manicure">Manicures</button>
        </div>
        
        <div class="gallery-grid" id="gallery-grid">
            @forelse($galleryItems as $item)
                <div class="gallery-item">
                    <div class="gallery-image">
                        <img src="{{ $item->image_url }}" alt="{{ $item->alt_text }}">
                    </div>
                    <div class="gallery-overlay">
                        <h3>{{ $item->title }}</h3>
                        <p>{{ $item->description }}</p>
                    </div>
                </div>
            @empty
                <div class="no-gallery-items">
                    <p>No gallery items available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('gallery-search');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryGrid = document.getElementById('gallery-grid');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    let currentCategory = 'all';
    let currentSearchTerm = '';
    
    // Store original gallery items data
    const originalItems = Array.from(galleryItems).map(item => ({
        element: item,
        title: item.querySelector('h3').textContent.toLowerCase(),
        description: item.querySelector('p').textContent.toLowerCase(),
        category: item.dataset.category || 'all'
    }));
    
    // Filter functionality
    function filterGallery() {
        galleryItems.forEach((item, index) => {
            const itemData = originalItems[index];
            const matchesCategory = currentCategory === 'all' || itemData.category === currentCategory;
            const matchesSearch = currentSearchTerm === '' || 
                itemData.title.includes(currentSearchTerm.toLowerCase()) ||
                itemData.description.includes(currentSearchTerm.toLowerCase());
            
            if (matchesCategory && matchesSearch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show no results message if no items are visible
        const visibleItems = Array.from(galleryItems).filter(item => item.style.display !== 'none');
        let noResultsMsg = document.querySelector('.no-results-message');
        
        if (visibleItems.length === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-message';
                noResultsMsg.innerHTML = '<p>No gallery items found matching your criteria.</p>';
                noResultsMsg.style.cssText = 'text-align: center; padding: 3rem; color: #666; font-size: 1.1rem; grid-column: 1 / -1;';
                galleryGrid.appendChild(noResultsMsg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        currentSearchTerm = this.value;
        filterGallery();
    });
    
    // Category filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            currentCategory = this.dataset.category;
            filterGallery();
        });
    });
    
    // Add category data attributes to gallery items
    galleryItems.forEach(item => {
        const title = item.querySelector('h3').textContent.toLowerCase();
        if (title.includes('pedicure')) {
            item.dataset.category = 'pedicure';
        } else if (title.includes('manicure')) {
            item.dataset.category = 'manicure';
        } else {
            item.dataset.category = 'nail_extension';
        }
    });
});
</script>

@endsection
