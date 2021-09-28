@extends('layouts.main')

@section('title', 'Search')

@section('css')
<style>
    .search-results-container {
        min-height: 500px;
        margin: 20px auto;
    }

    .search-results-container a {
        color: #2c2e43;
    }

    .search-results-container a:hover {
        text-decoration: underline;
    }

    .search-results-count {
        margin-bottom: 20px;
    }

    .search-results-container-algolia {
        min-height: 400px;
        margin: 40px 0;
        display: grid;
        grid-template-columns: 3fr 7fr;
        grid-gap: 20px;
    }

    .ais-hits--item .instantsearch-result {
        display: flex;
        align-items: center;
        padding: 10px;
    }

    .ais-hits--item .instantsearch-result img {
        margin-right: 40px;
    }

    .ais-hits--item .result-details {
        font-size: 0.875rem;
        line-height: 1.25rem;
        color: #919191;
    }

    .ais-hits--item .result-price {
        font-size: 0.875rem;
        line-height: 1.25rem;
        margin-top: 6px;
        font-weight: 500;
    }

    .ais-hits--item .algolia-thumb-result {
        max-height: 50px;
    }

    .ais-hits--item hr {
        border: 0.5px solid #cdcdcd;
    }

    .ais-refinement-list--label {
        color: #212121 !important;
        font-size: 18px !important;
        display: flex;
        align-items: center;
    }

    .ais-refinement-list--item {
        margin-bottom: 12px;
    }

    .ais-refinement-list--count {
        color: #212121 !important;
        background: rgba(39, 81, 108, 0.2) !important;
        margin-left: auto;
        margin-right: 57px;
    }

    @media (min-width: 1536px) {
        .container {
            max-width: 1280px;
        }
    }

</style>
@endsection

@section('content')
    <div class="search-results-container container">
        <div class="search-results-container-algolia">
            <div>
                <h2>Search</h2>
                <div id="search-box">
                    <!-- SearchBox widget will appear here -->
                </div>

                <div id="stats-container" class="mb-7"></div>

                <h2>Categories</h2>
                <div id="refinement-list">
                    <!-- RefinementList widget will appear here -->
                </div>
            </div>

            <div class="flex flex-col items-center">
                <div id="hits">
                    <!-- Hits widget will appear here -->
                </div>

                <div id="pagination" class="mt-4">
                    <!-- Pagination widget will appear here -->
                </div>
            </div>

        </div>
    </div> <!-- end search-results-container -->
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/instantsearch.js@2.6.0"></script>
<script src="{{ asset('js/algolia-instantsearch.js') }}"></script>
@endsection