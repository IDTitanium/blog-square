@props(['posts'])

@if (count($posts) > 0)
    <p class="text-end">@sortablelink('published_at', 'Sort By Publication date')</p>

    <div class="row">
        @foreach($posts as $post)
            <div class="card mb-4 shadow-sm p-3 mb-5 bg-body rounded">
                <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->description }}</p>
                <p class="card-text"><small class="text-muted">Published {{ \Carbon\Carbon::parse($post->published_at)->diffForHumans() }}</small></p>
                </div>
            </div>
        @endforeach
    </div>
    {!! $posts->appends(\Request::except('page'))->render() !!}

@else
<div class="svg-class">
<p class="text-center">Wow, such empty...</p>
<svg xmlns="http://www.w3.org/2000/svg" width="431.67004" height="319.09583" viewBox="0 0 731.67004 619.09583" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M0,599.58258c0,.66003,.53003,1.19,1.19006,1.19H730.48004c.65997,0,1.19-.52997,1.19-1.19,0-.65997-.53003-1.19-1.19-1.19H1.19006c-.66003,0-1.19006,.53003-1.19006,1.19Z" fill="#3f3d56"/><g><polygon points="405.33279 539.67963 405.33279 579.00788 435.06876 579.9671 433.82977 539.67963 405.33279 539.67963" fill="#ffb6b6"/><path d="M399.44815,561.56287c-.40186,0-.79529,.05151-1.17749,.16016-5.36661,1.53345-36.43088,29.26764-45.82361,37.73108-1.16064,1.04541-1.77701,2.53857-1.69177,4.09637,.08432,1.55127,.85617,2.96106,2.11609,3.8678,7.12393,5.13055,21.71747,13.24646,39.42471,9.96698,8.14499-1.50909,16.3649-2.45801,23.61719-3.29456,15.5256-1.79291,27.78851-3.20837,27.78851-8.70422,0-9.32526-2.56479-33.90259-5.78345-34.93494-.29227-.08899-.63043,.13678-1.02011,.68195-4.92447,6.89349-21.83923,3.22522-22.55679,3.06689l-.18829-.04218-.10678-.16016c-.08804-.13208-8.36981-12.43524-14.59821-12.43524v.00006Z" fill="#2f2e41"/><polygon points="349.69772 539.67963 349.69772 579.00788 379.43369 579.9671 378.1947 539.67963 349.69772 539.67963" fill="#ffb6b6"/><polygon points="337.7074 258.14698 321.88016 270.1373 319.0025 405.38806 345.86081 553.10877 380.87253 554.54761 381.83176 413.54151 426.91534 285.00528 417.8027 254.78971 337.7074 258.14698" fill="#2f2e41"/><polygon points="411.56775 281.1684 426.91534 285.00528 437.94644 553.10877 398.13858 549.75147 371.75989 360.30448 411.56775 281.1684" fill="#2f2e41"/><path d="M328.46735,619.09583c-13.64554,0-24.73285-6.03168-30.65399-10.09808-1.78918-1.229-2.89642-3.17932-3.03787-5.35162-.14331-2.19196,.711-4.29028,2.34372-5.75909,14.69656-13.22119,40.11978-35.61969,45.2522-37.08569,6.65182-1.90625,15.57898,10.8147,16.72742,12.50177,1.85849,.38031,17.08621,3.28986,21.38303-2.72778,.81964-1.14655,1.58871-1.19812,2.09363-1.03699,4.59192,1.47162,6.45041,31.03247,6.45041,35.84827,0,6.35114-12.01187,7.73749-28.63718,9.65686-7.23727,.83557-15.44034,1.78259-23.55347,3.28424-2.87579,.53302-5.67197,.76813-8.36792,.76813h.00003Z" fill="#2f2e41"/><g><g><path id="uuid-3ebb11e6-d96e-4ee1-8458-476e6815025a-302" d="M216.29097,83.16133c-5.08122-11.22495-3.16924-22.97686,4.2697-26.24812s17.58604,3.1766,22.66753,14.40625c2.0939,4.45761,3.04547,9.35706,2.77502,14.28847l20.90398,47.83572-23.5764,9.4637-18.10455-48.16229c-3.90472-3.09639-6.96864-7.06846-8.93527-11.58372h0Z" fill="#ffb6b6"/><path d="M360.75803,103.47245l.00006,.00004c12.74438,12.01732,11.94614,32.52065-1.69397,43.51077l-66.79614,53.81903c-7.28998,5.8737-18.1091,3.79842-22.70828-4.35593-17.55373-28.41862-20.86276-29.97717-31.06505-59.1032l28.77083-10.06383,16.22202,20.31259,35.41751-41.78159c10.70407-12.62745,29.8092-13.69467,41.85303-2.33793,0,0,0,.00004,0,.00003Z" fill="#6c63ff"/></g><polygon points="370.59531 82.96519 381.52081 104.97599 340.22693 124.9193 340.73285 89.63334 370.59531 82.96519" fill="#ffb6b6"/><circle cx="340.37491" cy="62.45883" r="37.15683" fill="#ffb6b6"/><path d="M340.12338,116.33831l38.09912-22.51312h0l.00003,.00003c27.9433,19.59661,51.21304,24.18123,51.95331,58.30318l-5.14987,81.3936,.30182,35.05417c.12671,14.71561-11.76743,26.71262-26.48361,26.71262h-54.40375c-14.39725,0-25.12381-13.28287-22.09238-27.35736l10.2709-47.68639-10.96793-92.9388,18.47232-10.96793,.00003-.00003v.00002Z" fill="#6c63ff"/><path d="M127.69193,69.64157c0-1.94656,1.57806-3.52486,3.52491-3.52486h39.70802c1.94684,0,3.52499,1.57816,3.52499,3.52486v.48058l97.93344,5.72877c.28357-1.11393,1.28473-1.9412,2.48691-1.9412h10.41351v-7.60669c0-1.69697,1.37579-3.07261,3.0726-3.07261h2.12274v-6.71572c0-1.0732,.86984-1.94318,1.94318-1.94318h5.92706c1.07333,0,1.94318,.86998,1.94318,1.94318v6.71572h1.94995c-.13867-.27115-.21817-.56176-.21817-.86589,0-1.43469,1.67993-2.59767,3.7522-2.59767s3.7522,1.16298,3.7522,2.59767c0,.37474-.11697,.73017-.3233,1.05192,1.19427,.42139,2.05508,1.54828,2.05508,2.88658v39.45829c0,1.69697-1.37579,3.07261-3.0726,3.07261h-19.83145c-1.69684,0-3.0726-1.37564-3.0726-3.07261v-5.29765h-10.41351c-1.34027,0-2.42856-1.02796-2.55087-2.33638l-98.0307,18.05106c-.44873,1.43089-1.78477,2.469-3.36378,2.469h-39.70802c-1.94684,0-3.52491-1.57803-3.52491-3.52459-.47015-16.09844,.57162-31.39244,0-45.48118l-.00005-.00002s0,.00002,0,.00002Z" fill="#3f3d56"/><g><path id="uuid-f9d64953-37a1-4c8a-9146-e86bcec63293-303" d="M281.02679,94.41958c-4.94943-11.28369-2.89993-23.0124,4.57681-26.19631,7.47672-3.18391,17.54764,3.38235,22.49725,14.67073,2.04156,4.48182,2.93567,9.39209,2.60748,14.31999l20.34232,48.07726-23.68561,9.18694-17.53925-48.37102c-3.86819-3.1419-6.88538-7.14959-8.79901-11.68757,0,0,0-.00002,0-.00002Z" fill="#ffb6b6"/><path d="M425.24606,116.42125l.00006,.00004c12.60278,12.16576,11.56448,32.65833-2.20343,43.48795l-67.42187,53.03307c-7.35828,5.78792-18.15234,3.58606-22.6557-4.62157-17.2197-28.62227-18.61456-24.7307-28.47504-53.9742l26.55392-16.74052,16.42007,22.02676,35.90442-41.36392c10.85123-12.50122,29.96753-13.34461,41.87753-1.84761h.00003Z" fill="#6c63ff"/></g><path d="M378.58475,81.15432l-6.86975,4.92164s-2.02161-21.45034-4.81082-22.40224-6.55246,3.9919-6.55246,3.9919l-2.74826,8.0528-9.08746-3.78793s-10.52219-5.66705-14.24112-6.93624-3.15527-12.04551-3.15527-12.04551c0,0-44.6449,6.1125-37.93729-19.62488,0,0,2.30975-18.93411,7.25354-15.17086s5.01028-5.55623,5.01028-5.55623l11.20111-2.40541s15.37033-20.70493,45.68988-3.09135c30.31955,17.61358,16.24759,74.0543,16.24759,74.0543,0,0,.00003,.00002,.00003,.00002Z" fill="#2f2e41"/></g></g></svg>
</div>
@endif

<style>
    svg {
      display: block;
      margin: 0 auto;
    }
    .svg-class {
        margin-top: 5rem;
    }
</style>