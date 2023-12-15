<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ page import="java.util.ArrayList" %>
<%@page import="BitBuzz.User, BitBuzz.Buzz" %>
<c:import url="header.jsp" />

<% if (request.getAttribute("buzz") != null) { %>
<div class="buzz-card">
            <a href="BitBuzz?action=displayProfile&username=${author.username}">${author.username}</a>
            <div class="content">${buzz.text}</div>
            <div class="timestamp">${buzz.timestamp}</div>
            <div class="like-count">${buzz.likeCount} Likes</div>

            <div class="form-container">
                <form action="BitBuzz" method="post">
                    <input type="hidden" name="action" value="like"/>
                    <input type="hidden" name="buzzId" value="${buzz.id}"/>
                    <input type="submit" value="Like"/>
                </form>
            </div>
        </div>
<div class="buzz-card">
    <form action='BitBuzz' method='post'>
        <input type='text' name='replyText' placeholder='Write your reply here'/><br>
        <input type='hidden' name='action' value='replyToPost' /><br>
        <input type='submit' value='Reply' /><br>
    </form>
</div>

<% } else { %>

<% }%>

<c:import url="footer.jsp" />
