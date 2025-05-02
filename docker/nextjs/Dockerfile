# Node.jsベースイメージ
FROM node:22.15.0-slim

# 作業ディレクトリを明示
WORKDIR /app

# package.jsonだけを一旦コピー（キャッシュ活用）
COPY package*.json /app/

# 依存インストール
RUN npm install


# # ポート公開
# EXPOSE 3000

# # 開発用の起動コマンド
# CMD ["npm", "run", "dev"]
