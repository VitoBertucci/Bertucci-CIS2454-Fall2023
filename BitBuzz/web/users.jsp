<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="BitBuzz.User" %>
<c:import url="/views/header.jsp" />


<h2>Users</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email Address</th>
        <th>Password Hash</th>
    </tr>
    <c:forEach items="${users}" var="user">
        <tr>        
            <td>${user.id}</td>
            <td>${user.username}</td>
            <td>${user.firstName}</td>
            <td>${user.lastName}</td>
            <td>${user.emailAddress}</td>
            <td>${user.password}</td>
        </tr>
    </c:forEach>
</table>
<c:import url="/views/footer.jsp" />
