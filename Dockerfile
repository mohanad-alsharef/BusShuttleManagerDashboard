FROM mattrayner/lamp:latest-1804

ADD initialize_db.sh /initialize_db.sh
RUN cat /run.sh | head -n -2 > /newrun.sh && \
    echo "/initialize_db.sh &" >> /newrun.sh && \
    echo "echo 'Starting supervisord'" >> /newrun.sh && \
    echo "exec supervisord -n" >> /newrun.sh && \
    chmod +x /newrun.sh

CMD ["/newrun.sh"]