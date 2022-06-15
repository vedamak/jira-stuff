<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Raketech | Coordinators</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <style>
        body { font-size: 14px; background-color: #2e3136; color: #ccc; }
        .no-underline { text-decoration: none !important; }
        #main-nav { background-color: #212529 !important; -webkit-box-shadow: 0 1px 5px 0 rgb(0 0 0 / 50%);-moz-box-shadow: 0 1px 5px 0 rgba(0,0,0,.5);box-shadow: 0 1px 5px 0 rgb(0 0 0 / 50%); }
        .table > :not(caption) > * > * { background-color: #2e3136 !important; color: #bbb !important; }
        .table th { text-transform: uppercase; background-color: #222 !important; }
        #spinner th, #spinner-myteam th { background-color: #2e3136 !important; }
        .dropdown-item { background-color: #212529; color: #ccc; font-size: 14px; }
        .dropdown-item:hover { background-color: #333; color: #ccc; }
        .form-control { background-color: #333 !important; color: #ccc !important; border-color: #444 !important; }
        .employee-off {  }
    </style>
  </head>
  <body>
  
<nav id="main-nav" class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">RakeTech | Coordinators</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="boardDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Boards
          </a>
          <ul id="boards-list" class="dropdown-menu bg-dark" aria-labelledby="boardDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="sprintDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sprints
          </a>
          <ul id="sprint-list" class="dropdown-menu bg-dark" aria-labelledby="sprintDropdown">
            <li><a class="dropdown-item" href="#">Another action</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/team.php">Devs</a>
        </li>
      </ul>
      <form class="d-flex">
        <button class="btn btn-secondary btn-sm" id="refresh" type="button">
          <span id="spinner-refresh" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
          Refresh
        </button>
      </form>
    </div>
  </div>
</nav>

    <div class="mt-3">
        <h5 class="text-white ps-3">My Team</h5>

        <table class="table table-hover table-bordered text-secondary table-dark">
            <thead>
                <tr class="text-uppercase">
                    <th width="20"></th>
                    <th width="120">Employee ID</th>
                    <th nowrap>Name</th>
                    <th nowrap></th>
                    <th nowrap>From</th>
                    <th nowrap>To</th>
                    <th nowrap>Day(s)</th>
                </tr>
                <tr id="spinner-myteam">
                    <th colspan="7" class="text-center">
                        <div class="spinner-border spinner-border-sm text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="tbody-myteam"></tbody>
        </table>

        <h5 class="text-white mt-3 ps-3">Time off not logged</h5>

        <div id="time-notlogged" class="ps-3">
            <div class="spinner-border spinner-border-sm text-light" role="status" style="display: none;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>


        <form action="" id="time-off" method="get" class="mt-3">
            <div class="container-fluid">
                <div class="row g-3">
                    <div class="col-auto">
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Employee name" aria-label="Employee name">
                    </div>
                    <div class="col-auto">
                        <input type="date" name="date" class="form-control form-control-sm" placeholder="date" aria-label="date" maxlength="10" value="<?php echo date('Y-m-d');?>">
                    </div>
                    <div class="col-auto">
                        <input type="text" name="days" class="form-control form-control-sm" placeholder="days off e.g. 0.5 or 2" aria-label="days off">
                    </div>
                    <div class="col-auto">
                        <button type="submit" id="btn-time-off" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="container-fluid mt-3">
            <?php for($i=1;$i<=5;$i++) { ?>
            <div class="employee-off">
                <div class="row mb-2">
                    <div class="col-auto">James Ramroop</div>
                    <div class="col-auto">2022-06-14</div>
                    <div class="col-auto">0.5</div>
                    <div class="col-auto"><a href="#" class="text-danger no-underline">&cross;</a></div>
                </div>
            </div>
            <?php } ?>
        </div>


        <h5 class="text-white mt-5 ps-3">Who's out</h5>
        <table class="table table-hover table-bordered text-secondary table-dark">
            <thead>
                <tr class="text-uppercase">
                    <th width="20"></th>
                    <th width="120">Employee ID</th>
                    <th nowrap>Name</th>
                    <th nowrap></th>
                    <th nowrap>From</th>
                    <th nowrap>To</th>
                    <th nowrap>Day(s)</th>
                </tr>
                <tr id="spinner">
                    <th colspan="7" class="text-center">
                        <div class="spinner-border spinner-border-sm text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="tbody"></tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        var myTeam = [];
        jQuery(document).ready(function(){

            jQuery(document).on('submit', '#time-off', function(e){
                e.preventDefault();
                let data = jQuery(this).serialize();
                jQuery.ajax({
                    url: "/ajax.php?action=addDbTimeOff",
                    method: "post",
                    data: data,
                    cache: false
                })
                .done(function( res ) {
                    console.log(res);
                });
            });

            jQuery.ajax({
                url: "/ajax.php?action=bambooWhosOut",
                cache: true
            })
            .done(function( res ) {
                
                if(res.length > 0)
                {
                    allt = '';
                    myt = '';

                    jQuery.each(res, function(i, v) 
                    {
                        teamChecked = '';
                        if(localStorage.getItem('myTeam_'+v.employeeId)) { teamChecked = 'checked'; }

                        html = '<tr class="emp-'+v.employeeId+'">';
                        html += '<td><input type="checkbox" class="myteam" value="'+v.employeeId+'" '+teamChecked+' /></td>';
                        html += '<td>'+v.employeeId+'</td>'
                        html += '<td nowrap>'+v.name+'</td>'
                        html += '<td nowrap>'+dateCheck(v.start, v.end)+'</td>'
                        html += '<td nowrap>'+v.start+'</td>'
                        html += '<td nowrap>'+v.end+'</td>';
                        html += '<td nowrap>'+daysDiff(v.start, v.end)+'</td>';
                        html += '</tr>';

                        allt += html;

                        eDate = Date.parse(v.end);
                        cDate = new Date();
                        
                        if( teamChecked != '' && eDate >= cDate) { myt += html; }
                    });
                }

                jQuery('#spinner, #spinner-myteam').hide();
                jQuery( "#tbody" ).html( allt );
                jQuery( "#tbody-myteam" ).html( myt );
            });

            jQuery(document).on('click', 'input.myteam', function(e) {
                let id = jQuery(this).val();   console.log(jQuery(this).is(':checked'));
                if(jQuery(this).is(':checked')) {
                    localStorage.setItem('myTeam_'+id, 'Y');
                }
                else {
                    localStorage.removeItem('myTeam_'+id);
                    jQuery('#tbody-myteam tr.emp-'+id).remove();
                }
            });
        });

        function daysDiff(start, end)
        {
            const date1 = new Date(start);
            const date2 = new Date(end);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

            return ( diffDays + 1 );
        }

        function dateCheck( from, to ) {

            var fDate,lDate,cDate;
            fDate = Date.parse(from);
            lDate = Date.parse(to);
            cDate = new Date();

            if((cDate <= lDate && cDate >= fDate)) 
            {
                return '<span class="badge rounded-pill text-bg-success text-uppercase">Today</span>';
            }

            if(lDate < cDate) {
                return ( daysDiff(cDate, fDate) - 1 ) + ' day(s) ago';
            }

            return 'In ' + ( daysDiff(cDate, fDate) - 1 ) + ' day(s)';
        }
    </script>
  </body>
</html>
