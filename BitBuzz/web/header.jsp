<%@page import="BitBuzz.User"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>

<% 
    User loggedInUser = (User) session.getAttribute("user"); 
    String currentPage = request.getRequestURI();
    currentPage = currentPage.substring(currentPage.lastIndexOf("/") + 1);
    String currentAction = request.getParameter("action");
%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>BitBuzz</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <% if (session != null && session.getAttribute("user") != null) {%>
                    <li><%= loggedInUser.getUsername()%></li>
                    <li><a href="BitBuzz?action=home" class="<%= "home".equals(currentAction) ? "active-link" : "" %>">Home</a></li>
                    <li><a href="BitBuzz?action=listUsers" class="<%= "listUsers".equals(currentAction) ? "active-link" : "" %>">Users</a></li>
                    <li><a href="BitBuzz?action=listBuzzes" class="<%= "listBuzzes".equals(currentAction) ? "active-link" : "" %>">Buzzes</a></li>
                    <li><a href="BitBuzz?action=listData" class="<%= "listData".equals(currentAction) ? "active-link" : "" %>">Data</a></li>
                    <li><a href="BitBuzz?action=logout">Logout</a></li>
                        <% } else { %>
                    <li>No User</li>
                        <% }%>
                </ul>
            </nav>
        </header>

        <main>
            <div class="content-wrapper">