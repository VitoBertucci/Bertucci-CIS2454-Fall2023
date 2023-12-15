<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ page import="java.util.ArrayList" %>
<%@page import="BitBuzz.User, BitBuzz.Buzz" %>
<c:import url="header.jsp"/>

<% if (session != null && session.getAttribute("user") != null) { %>


<div class="timeline">
    <div class="new-post">
        <form action='BitBuzz' method='post'>
            <textarea name='text' placeholder="What's happening?" rows='4'></textarea><br>
            <input type='hidden' name='action' value='createBuzz' />
            <input type='submit' value='Add Buzz' /><br>
        </form>
    </div>
    <c:forEach items="${followingBuzzes}" var="buzz">
        <div class="buzz-card">
            <a href="BitBuzz?action=displayProfile&username=${buzz.authorUsername}">${buzz.authorUsername}</a>
            <div class="content">${buzz.text}</div>
            <div class="timestamp">${buzz.timestamp}</div>
            <div class="like-count">${buzz.likeCount} Likes</div>

            <div class="form-container">
                <form action="BitBuzz" method="post">
                    <input type="hidden" name="action" value="like"/>
                    <input type="hidden" name="buzzId" value="${buzz.id}"/>
                    <input type="submit" value="Like"/>
                </form>

                <form action="BitBuzz" method="post">
                    <input type="hidden" name="action" value="reply"/>
                    <input type="hidden" name="buzzId" value="${buzz.id}"/>
                    <input type="hidden" name="authorUsername" value="${buzz.authorUsername}"/>
                    <input type="submit" value="Reply"/>
                </form>
            </div>
        </div>
    </c:forEach>
</div>

<% } else { %>

    <c:import url="login.jsp" />
    
<% }%>
<c:import url="footer.jsp" />
