<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="BitBuzz.Buzz" %>
<c:import url="header.jsp" />


<h1>Users</h1>
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

<div class="form-container">
    <form action='BitBuzz' method='post'>
        <input type='text' name='text' placeholder='Text'/><br>
        <input type='hidden' name='action' value='createBuzz' /><br>
        <input type='submit' value='Add Buzz' /><br>
    </form>
</div>
<c:import url="footer.jsp" />
