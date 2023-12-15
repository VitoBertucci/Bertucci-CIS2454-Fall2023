<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="BitBuzz.User, BitBuzz.Buzz" %>
<c:import url="header.jsp" />

<div class="page-title">
    <h1>Data - Users and Buzzes</h1>
</div>

<div class="table-container">
    <table>
        <tr>
            <th>Username</th>
            <th>Email Address</th>
            <th>Follow</th>
        </tr>
        <c:forEach items="${users}" var="user">
            <tr>
                <td>
                    <a href="BitBuzz?action=displayProfile&username=${user.username}">${user.username}</a>
                </td>
                <td>${user.emailAddress}</td>
                <td>
                    <div class='follow-form'>
                        <form action='BitBuzz' method='post'>
                            <input type='hidden' name='action' value='followUser' />
                            <input type='hidden' name='userIdToFollow' value='${user.id}' />
                            <input type='submit' value='Follow'/>
                        </form>
                    </div>
                </td>
            </tr>
        </c:forEach>
    </table>

    <table>
        <tr>
            <th>Text</th>
            <th>Timestamp</th>
            <th>Likes</th>
        </tr>
        <c:forEach items="${buzzes}" var="buzz">
            <tr>        
                <td>${buzz.text}</td>
                <td>${buzz.timestamp}</td>
                <td>${buzz.likeCount}</td>
            </tr>
        </c:forEach>
    </table>
</div>

<c:import url="footer.jsp" />
