<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Raketech | Coordinators</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <style>
        body { font-size: 14px; background-color: #2e3136; }
        #main-nav { background-color: #212529 !important; -webkit-box-shadow: 0 1px 5px 0 rgb(0 0 0 / 50%);-moz-box-shadow: 0 1px 5px 0 rgba(0,0,0,.5);box-shadow: 0 1px 5px 0 rgb(0 0 0 / 50%); }
        .table > :not(caption) > * > * { background-color: #2e3136 !important; color: #bbb !important; }
        .table th { text-transform: uppercase; background-color: #222 !important; }
        #spinner th, #spinner-myteam th { background-color: #2e3136 !important; }
        .dropdown-item { background-color: #212529; color: #ccc; font-size: 14px; }
        .dropdown-item:hover { background-color: #333; color: #ccc; }
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
            <span id="spinner-boards" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> 
            Boards
          </a>
          <ul id="boards-list" class="dropdown-menu bg-dark" aria-labelledby="boardDropdown"></ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="sprintDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span id="spinner-sprints" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span> 
            Sprints
          </a>
          <ul id="sprint-list" class="dropdown-menu bg-dark" aria-labelledby="sprintDropdown">
            <li><a class="dropdown-item" href="#"> - choose a board - </a></li>
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

    <div class="">

        <table class="table table-hover table-bordered text-secondary table-dark">
            <thead>
                <tr class="text-uppercase">
                    <th>
                      Issues 
                      <span id="board-sprint" style="display: none;">
                        <span class="badge bg-success">Board &rsaquo; <span id="board-name"></span></span> 
                        <span class="badge bg-primary">Sprint &rsaquo; <span id="sprint-name"></span></span> 
                      </span>
                    </th>
                    <th nowrap>Status</th>
                    <th nowrap>Due Date</th>
                    <th nowrap>Priority</th>
                    <th nowrap>Assigned</th>
                    <th nowrap>Reporter</th>
                    <th nowrap>Site</th>
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
        jQuery(document).ready(function(){
          loadBoards();
          let boardId = localStorage.getItem('boardId');
          if(boardId != null) { loadSprints( boardId ); }
          jiraIssues();
          jQuery(document).on('click', '.select-board', function(e) {
            e.preventDefault();
            let boardId = jQuery(this).attr('data-id');
            let boardName = jQuery(this).text();
            localStorage.setItem('boardId', boardId);
            localStorage.setItem('boardName', boardName);
            loadSprints( boardId );
          });

          jQuery(document).on('click', '.select-sprint', function(e) {
            e.preventDefault();
            let sprintId = jQuery(this).attr('data-id');
            let sprintName = jQuery(this).text();
            localStorage.setItem('sprintId', sprintId);
            localStorage.setItem('sprintName', sprintName);
            jiraIssues();
          });

          jQuery(document).on('click', '#refresh', function() { 
            jQuery('#spinner-refresh').show();
            jQuery('#spinner-boards').show();
            loadBoards();
            if(boardId != null) { loadSprints( boardId ); }
            jiraIssues(); 
          });
        });

        function loadSprints( boardId )
        {
          jQuery('#spinner-sprints').show();
          jQuery.ajax({
                url: "/ajax.php?action=getSprints&boardId="+boardId,
                cache: true
            })
            .done(function( res ) 
            {
              if(res.length > 0)
              {
                  html = '';

                  jQuery.each(res, function(i, v) 
                  {
                      html += '<li><a class="dropdown-item select-sprint" href="javascript:void(0);" data-id="'+v.id+'">'+v.name+'';
                      if(v.state == 'active') { html += ' (active)'; }
                      html += '</a></li>';
                  });
              }
              jQuery( "#sprint-list" ).html( html );
              //jQuery( "#sprintDropdown" ).addClass( 'show' );
              //jQuery( "#sprintDropdown" ).attr( 'aria-expanded', 'true' );
              //jQuery( "#sprint-list" ).addClass( 'show' );
              //jQuery( "#sprint-list" ).attr( 'data-bs-popper', 'static' );
              jQuery('#spinner-sprints').hide();
            });
        }

        function loadBoards()
        {
          jQuery.ajax({
                url: "/ajax.php?action=getBoards",
                cache: true
            })
            .done(function( res ) 
            {
              if(res.length > 0)
              {
                  html = '';

                  jQuery.each(res, function(i, v) 
                  {
                      html += '<li><a class="dropdown-item select-board" href="javascript:void(0);" data-id="'+v.id+'">'+v.displayName+'</a></li>';
                  });
              }
              jQuery( "#boards-list" ).html( html );
              jQuery('#spinner-boards').hide();
            });
        }

        function jiraIssues()
        {
          jQuery('#spinner').show();

          let boardId = localStorage.getItem('boardId');
          let sprintId = localStorage.getItem('sprintId');

          if( boardId == null || sprintId == null )
          {
            jQuery('#spinner').hide();
            jQuery( "#tbody" ).html( '<tr><td colspan="7" class="text-center">Please select a board and sprint.</td></tr>' );
            return;
          }

          jQuery.ajax({
                url: "/ajax.php?action=getSprintIssues&boardId="+boardId+"&sprintId="+sprintId,
                cache: false
            })
            .done(function( res ) 
            {    
                if(res.length > 0)
                {
                    html = '';

                    jQuery.each(res, function(i, v) 
                    {
                        html += '<tr>';
                        html += '<td><a href="'+v.url+'" target="_blank">'+v.key+' &rsaquo; '+v.summary+'</a></td>'
                        html += '<td nowrap class="text-uppercase"><span class="badge bg-secondary">'+v.status+'</span></td>'
                        html += '<td nowrap>'+v.due_date+'</td>'
                        html += '<td nowrap title="'+v.priority+'"><img src="'+v.priority_icon+'" height="15" alt="'+v.priority+'" /></td>'
                        html += '<td nowrap>'+v.assignee+'</td>';
                        html += '<td nowrap>'+v.reporter+'</td>';
                        html += '<td nowrap> - </td>';
                        html += '</tr>';
                    });
                }
                else {
                  html = '<tr><td colspan="7" class="text-center">There are no issues in this sprint.</td></tr>';
                }
                jQuery('#spinner').hide();
                jQuery('#board-name').html(localStorage.getItem('boardName'));
                jQuery('#sprint-name').html(localStorage.getItem('sprintName'));
                jQuery('#board-sprint').show();
                jQuery( "#tbody" ).html( html );
                jQuery('#spinner-refresh').hide();
            });
        }
    </script>
  </body>
</html>
