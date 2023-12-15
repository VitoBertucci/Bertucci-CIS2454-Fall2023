<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>

<c:import url="header.jsp"/>

<div class="page-title">
    <h1>BitBuzz - Like Twitter but Wayyyy Cooler</h1>
</div>

<% if (request.getAttribute("signupError") != null) {%>
        <p><%= request.getAttribute("signupError")%></p>
<% }%>

<form action='BitBuzz' method='post'>
    <input type='text' name='username' placeholder='Username'/><br>
    <input type='text' name='password' placeholder='Password'/><br>
    <input type='text' name='emailAddress' placeholder='Email Address'/><br>
    <input type='hidden' name='action' value='signUp' /><br>
    <input type='submit' value='Sign Up' /><br>
    <a class="signup-link" href="login.jsp">Log In</a>
</form>

<c:import url="footer.jsp"/>
