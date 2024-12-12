<component src="header.php">

<foreach array="$users" value="$user">
    <if condition="$user == 3">
        <auth>
            <$user['id']>
        <else>
            
            <h1>Daniel's Blog</h1>
            <p></p>
        </auth>
    </if>
    
    <foreach array="$users" value="$user">
        <if condition="$daniel == 3">
        
        </if>
    </foreach>
</foreach>

<component src="footer.php">