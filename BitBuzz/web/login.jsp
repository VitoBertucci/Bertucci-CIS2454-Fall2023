<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>

<c:import url="header.jsp" />

<% if (request.getAttribute("loginError") != null) {%>
        <p><%= request.getAttribute("loginError")%></p>
<% }%>

<form action="BitBuzz" method="post">
    <input type='text' name='username' placeholder='Username'/><br>
    <input type='text' name='password' placeholder='Password'/><br>
    <input type='hidden' name='action' value='login' /><br>
    <input type="submit" value="Login">
</form>

<c:import url="footer.jsp" />
