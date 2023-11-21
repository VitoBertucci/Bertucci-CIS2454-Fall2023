<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="BitBuzz.User, BitBuzz.Buzz" %>
<c:import url="header.jsp" />

<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email Address</th>
            <th>Password</th>
        </tr>
        <c:forEach items="${users}" var="user">
            <tr>        
                <td>${user.id}</td>
                <td>${user.username}</td>
                <td>${user.emailAddress}</td>
                <td>...${fn:substring(user.password, fn:length(user.password) - 4, fn:length(user.password))}</td>
            </tr>
        </c:forEach>
    </table>

    <table>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Text</th>
            <th>Timestamp</th>
        </tr>
        <c:forEach items="${buzzes}" var="buzz">
            <tr>        
                <td>${buzz.id}</td>
                <td>${buzz.userId}</td>
                <td>${buzz.text}</td>
                <td>${buzz.timestamp}</td>
            </tr>
        </c:forEach>
    </table>
</div>

<div class="form-container">
    <form action='BitBuzz' method='post'>
        <input type='text' name='username' placeholder='Username'/><br>
        <input type='text' name='password' placeholder='Password'/><br>
        <input type='text' name='emailAddress' placeholder='Email Address'/><br>
        <input type='hidden' name='action' value='createUser' /><br>
        <input type='submit' value='Add User' /><br>
    </form>

    <form action='BitBuzz' method='post'>
        <input type='text' name='text' placeholder='Text'/><br>
        <input type='hidden' name='action' value='createBuzz' /><br>
        <input type='submit' value='Add Buzz' /><br>
    </form>
</div>

<c:import url="footer.jsp" />
