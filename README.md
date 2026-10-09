# Movie Filters and Navigation

## Q1

The Movies list already has one route, and adding filters did not change the page's path. Laravel's router matches the path, such as `/movies`, not the query string after `?`. The controller reads `genre` and `year` from that query string, so the same route can handle either filter, both, or neither.

## Q2

If course and year were both route parameters, their values would occupy positions in the path. With a route like `/students/{course}/{year}`, a year-only URL would need an empty course position, conceptually `/students//4`, which is not a useful URL and normally will not match. Query strings avoid that problem: a year-only filter can simply be `/students?year=4`.

## Q3

The detail page needed the pattern to cover more than the exact `/movies` path, so I used `movies/*` to include paths such as `/movies/1`. A filter is attached to `/movies` as a query string, not another path segment. Since the path stays `/movies`, no extra pattern was needed for filters.

## Q4

The old filter method was removed because its behavior has been replaced by the query-filtered index, and the old URL now redirects there. Keeping the old method would leave a second, unused implementation. The empty `store` and `update` methods are unfinished resource actions reserved for future work, so they remain as placeholders.
