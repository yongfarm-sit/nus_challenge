import os
import pdfplumber
import argparse
import sys
from openai import AzureOpenAI
from dotenv import load_dotenv

# Load environment variables from .env
load_dotenv()

# Retrieve API credentials from environment variables
subscription_key = os.getenv("AZURE_OPENAI_API_KEY")
endpoint = os.getenv("ENDPOINT_URL")
deployment = os.getenv("DEPLOYMENT_NAME")
apiversion = os.getenv("API_VERSION")

# Check if any required environment variable is missing
missing_vars = []
if not subscription_key:
    missing_vars.append("AZURE_OPENAI_API_KEY")
if not endpoint:
    missing_vars.append("ENDPOINT_URL")
if not deployment:
    missing_vars.append("DEPLOYMENT_NAME")
if not apiversion:
    missing_vars.append("API_VERSION")

if missing_vars:
    print(f"Error: The following environment variables are missing: {', '.join(missing_vars)}")
    sys.exit(1)

print("All required API environment variables are set.")

# Initialize the Azure OpenAI client
client = AzureOpenAI(
    azure_endpoint=endpoint,
    api_key=subscription_key,
    api_version=apiversion,
)

def read_pdf(file_path):
    """Extracts text from a PDF file."""
    try:
        with pdfplumber.open(file_path) as pdf:
            text = "".join(page.extract_text() or "" for page in pdf.pages)
        return text.strip()  # Remove any leading/trailing whitespace
    except FileNotFoundError:
        print(f"Error: File not found - {file_path}")
        return None
    except Exception as e:
        print(f"Error reading PDF: {e}")
        return None

def process_text_with_openai(text):
    """Processes the extracted text using Azure OpenAI API."""
    
    chat_prompt = [
        {"role": "system", "content": f"""You are an auditor. Audit the financial document and identify an inconsistencies. 
        The standards to adhere to have been preloaded and are as follows:  
        ssa-200 and ssa-315 from Institute Of Singapore Chartered Accountants: https://isca.org.sg/standards-guidance/audit-assurance/standards-and-guidance/singapore-standards-on-auditing-(ssas)
        Do not include an introduction.  
        Use `##` for section titles.  
        List and identify any inconsistencies or errors.
        Specifically highly the inconsistencies and errors to make them more eye catching and state which standard it is failing
        Format the output in markdown"""},
        {"role": "user", "content": text}
    ]

    try:
        completion = client.chat.completions.create(
            model=deployment,
            messages=chat_prompt,
            max_tokens=800,
            temperature=0.2,
            top_p=0.95,
            frequency_penalty=0,
            presence_penalty=0,
            stream=False,
        )
        return completion.choices[0].message.content
    except Exception as e:
        print(f"Error generating response from OpenAI: {e}")
        return None

def main():
    """Main function to handle CLI arguments and process the PDF."""
    parser = argparse.ArgumentParser(description="Extract text from a PDF file using pdfplumber and process it with Azure OpenAI.")
    parser.add_argument("file_path", help="Path to the PDF file")

    args = parser.parse_args()
    file_path = args.file_path

    # Extract text from the PDF
    text = read_pdf(file_path)
    if text:
        print("\nExtracted Text:\n" + "-"*40)
        print(text)

        # Process the text with Azure OpenAI API
        openai_response = process_text_with_openai(text)
        if openai_response:
            print("\nAI Response:\n" + "-"*40)
            print(openai_response)

            # Save response to a Markdown file
            output_file = "audit_report.md"
            with open(output_file, "w", encoding="utf-8") as md_file:
                md_file.write(openai_response)

            print(f"\nAI response saved to {output_file}")

if __name__ == "__main__":
    main()

